<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\NilaiUjian;
use App\Models\WawancaraAnak;
use App\Models\WawancaraOrtu;
use App\Models\PeriodePendaftaran;
use Illuminate\Http\Request;

class PanitiaDashboardController extends Controller
{
    /**
     * Display the candidate queue based on panitia role.
     */
    public function index()
    {
        $panitia = auth()->guard('panitia')->user();
        // Fallback for dev mode
        $role = $panitia ? $panitia->role_panitia : 'pengawas_ujian';
        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();

        $periodFilter = function ($query) use ($activePeriod) {
            $query->where('status_verifikasi', 'terverifikasi_onsite');
            if ($activePeriod) {
                $query->where('periode_pendaftaran_id', $activePeriod->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        };

        if ($role === 'pengawas_ujian') {
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereHas('nilaiUjian')
                ->count();

            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('nilaiUjian')
                ->count();

            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->with(['calonMurid', 'program', 'nilaiUjian'])
                ->get();
        } else {
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereHas('wawancaraAnak')
                ->count();

            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('wawancaraAnak')
                ->count();

            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->with(['calonMurid', 'program', 'wawancaraAnak', 'wawancaraOrtu'])
                ->get();
        }

        return view('dashboard.panitia', compact('telahDiujiCount', 'antreanCount', 'queue', 'role', 'activePeriod'));
    }

    /**
     * Show grading panel for exam scores.
     */
    public function detailUjian($id)
    {
        $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'nilaiUjian'])->findOrFail($id);
        return view('dashboard.panitia-grading-ujian', compact('pendaftaran'));
    }

    /**
     * Store exam scores (integer 1-100).
     */
    public function storeUjian(Request $request, $id)
    {
        $request->validate([
            'nilai_hafalan' => 'required|integer|between:1,100',
            'nilai_iqro' => 'required|integer|between:1,100',
            'nilai_calistung' => 'required|integer|between:1,100',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $panitiaId = auth()->guard('panitia')->id() ?: 'PAN0001';

        $nilai = NilaiUjian::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia' => $panitiaId,
                'nilai_hafalan' => $request->nilai_hafalan,
                'nilai_iqro' => $request->nilai_iqro,
                'nilai_calistung' => $request->nilai_calistung,
            ]
        );

        // Check if interview is also completed
        if ($pendaftaran->wawancaraAnak()->exists() && $pendaftaran->wawancaraOrtu()->exists()) {
            $pendaftaran->status_kelulusan = null; // reset until recalculation/TU approval
            $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
            // Mark general transition status
            $pendaftaran->status = 'cek_kelulusan'; // for backwards compatibility if needed
            $pendaftaran->status_kelulusan = null;
            $pendaftaran->save();
            
            // Trigger DSS ranking recalculation
            \App\Services\DssService::recalculateAll();
        }

        return redirect()->route('panitia.dashboard')->with('success_grading', 'Nilai ujian berhasil disimpan!');
    }

    /**
     * Show grading panel for interview notes.
     */
    public function detailWawancara($id)
    {
        $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'wawancaraAnak', 'wawancaraOrtu'])->findOrFail($id);
        return view('dashboard.panitia-grading-wawancara', compact('pendaftaran'));
    }

    /**
     * Store interview notes (text description) and scores.
     */
    public function storeWawancara(Request $request, $id)
    {
        $request->validate([
            'wawancara_aism' => 'required|string|max:1000',
            'wawancara_irqa' => 'required|string|max:1000',
            'wawancara_calistung' => 'required|string|max:1000',
            'wawancara_dikte' => 'required|string|max:1000',
            'wawancara_kemandirian' => 'required|string|max:1000',
            'rekap_wawancara' => 'required|string|max:2000',
            'komitmen_ortu' => 'required|string|max:1000',
            // Numeric scores
            'nilai_aism' => 'required|integer|between:1,100',
            'nilai_dikte' => 'required|integer|between:1,100',
            'nilai_kemandirian' => 'required|integer|between:1,100',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $panitiaId = auth()->guard('panitia')->id() ?: 'PAN0001';

        WawancaraAnak::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia' => $panitiaId,
                'wawancara_aism' => $request->wawancara_aism,
                'wawancara_irqa' => $request->wawancara_irqa,
                'wawancara_calistung' => $request->wawancara_calistung,
                'wawancara_dikte' => $request->wawancara_dikte,
                'wawancara_kemandirian' => $request->wawancara_kemandirian,
                'rekap_wawancara' => $request->rekap_wawancara,
            ]
        );

        WawancaraOrtu::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia' => $panitiaId,
                'komitmen_ortu' => $request->komitmen_ortu,
            ]
        );

        // Update remaining numeric values in NilaiUjian
        NilaiUjian::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia' => $panitiaId,
                'nilai_aism' => $request->nilai_aism,
                'nilai_dikte' => $request->nilai_dikte,
                'nilai_kemandirian' => $request->nilai_kemandirian,
            ]
        );

        // Check if exams are also completed
        if ($pendaftaran->nilaiUjian()->exists()) {
            $pendaftaran->status_kelulusan = null;
            $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
            // Trigger DSS ranking recalculation
            \App\Services\DssService::recalculateAll();
        }

        return redirect()->route('panitia.dashboard')->with('success_grading', 'Hasil wawancara berhasil disimpan!');
    }
}
