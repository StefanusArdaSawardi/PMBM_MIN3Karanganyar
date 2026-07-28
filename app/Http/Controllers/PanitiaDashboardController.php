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
    public function index()
    {
        $panitia = auth()->guard('panitia')->user();
        $role = $panitia ? $panitia->role_panitia : 'pengawas_ujian';
        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();

        $periodFilter = function ($query) use ($activePeriod) {
            if ($activePeriod) {
                $query->where('periode_pendaftaran_id', $activePeriod->id);
            } else {
                $query->whereRaw('1 = 0');
            }
        };

        if ($role === 'pengawas_ujian') {
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })->whereHas('nilaiUjian')->count();
            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })->whereDoesntHave('nilaiUjian')->count();
            
            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('nilaiUjian')
                ->with(['calonMurid', 'program'])
                ->get();
        } else {
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })->whereHas('wawancaraOrtu')->count();
            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })->whereDoesntHave('wawancaraOrtu')->count();
            
            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('wawancaraOrtu')
                ->with(['calonMurid', 'program'])
                ->get();
        }

        return view('dashboard.panitia', compact('telahDiujiCount', 'antreanCount', 'queue', 'role', 'activePeriod'));
    }

    public function detailUjian($id)
    {
        $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'nilaiUjian'])->findOrFail($id);
        return view('dashboard.panitia-grading-ujian', compact('pendaftaran'));
    }

    public function storeUjian(Request $request, $id)
    {
        $request->validate([
            'nilai_hafalan'     => 'required|integer|between:1,100',
            'nilai_aism'        => 'nullable|integer|between:1,100',
            'nilai_iqro'        => 'required|integer|between:1,100',
            'nilai_calistung'   => 'required|integer|between:1,100',
            'nilai_dikte'       => 'nullable|integer|between:1,100',
            'nilai_kemandirian' => 'nullable|integer|between:1,100',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $panitiaId = auth()->guard('panitia')->id() ?: 'PAN0001';

        $nilai = NilaiUjian::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia'        => $panitiaId,
                'nilai_hafalan'     => $request->nilai_hafalan,
                'nilai_aism'        => $request->nilai_aism,
                'nilai_iqro'        => $request->nilai_iqro,
                'nilai_calistung'   => $request->nilai_calistung,
                'nilai_dikte'       => $request->nilai_dikte,
                'nilai_kemandirian' => $request->nilai_kemandirian,
            ]
        );

        WawancaraAnak::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia' => $panitiaId,
                'wawancara_aism' => $request->catatan_aism,
                'wawancara_irqa' => $request->catatan_hafalan ?: $request->catatan_iqro,
                'wawancara_calistung' => $request->catatan_calistung,
                'wawancara_dikte' => $request->catatan_dikte,
                'wawancara_kemandirian' => $request->catatan_kemandirian,
                'rekap_wawancara' => $request->catatan_hafalan ?: 'Observasi evaluasi anak telah diuji oleh pengawas ujian.',
            ]
        );

        if ($pendaftaran->status_verifikasi !== 'terverifikasi_onsite') {
            $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
            $pendaftaran->save();
        }

        \App\Services\DssService::recalculateAll();

        return redirect()->route('panitia.dashboard')->with('success_grading', 'Seluruh instrumen nilai ujian berhasil disimpan!');
    }

    public function detailWawancara($id)
    {
        $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'wawancaraAnak', 'wawancaraOrtu'])->findOrFail($id);
        return view('dashboard.panitia-wawancara-ortu', compact('pendaftaran'));
    }

    public function storeWawancara(Request $request, $id)
    {
        $request->validate([
            'komitmen_ortu' => 'required|string|max:1000',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $panitiaId = auth()->guard('panitia')->id() ?: 'PAN0001';

        WawancaraOrtu::updateOrCreate(
            ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
            [
                'id_panitia' => $panitiaId,
                'komitmen_ortu' => $request->komitmen_ortu,
            ]
        );

        if ($pendaftaran->status_verifikasi !== 'terverifikasi_onsite') {
            $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
            $pendaftaran->save();
        }

        \App\Services\DssService::recalculateAll();

        return redirect()->route('panitia.hasil-nilai')->with('success_grading', 'Hasil wawancara berhasil disimpan!');
    }

    public function hasilNilai()
    {
        $panitia = auth()->guard('panitia')->user();
        $role = $panitia ? $panitia->role_panitia : 'petugas_wawancara';
        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();

        $query = Pendaftaran::with(['calonMurid', 'program', 'nilaiUjian', 'wawancaraOrtu', 'dssRanking']);

        if ($activePeriod) {
            $query->where('periode_pendaftaran_id', $activePeriod->id);
        }

        $students = $query->where(function($q) {
            $q->whereHas('nilaiUjian')->orWhereHas('wawancaraOrtu');
        })->get();

        $statsQuery = Pendaftaran::query();
        if ($activePeriod) {
            $statsQuery->where('periode_pendaftaran_id', $activePeriod->id);
        }

        $totalPendaftar = (clone $statsQuery)->count();
        $lulusCount = (clone $statsQuery)->where('status_kelulusan', 'lulus')->count();
        $cadanganCount = (clone $statsQuery)->where('status_kelulusan', 'cadangan')->count();
        $tidakLulusCount = (clone $statsQuery)->where('status_kelulusan', 'tidak_lulus')->count();

        return view('dashboard.panitia-hasil-nilai', compact(
            'students', 'role', 'activePeriod', 'totalPendaftar', 'lulusCount', 'cadanganCount', 'tidakLulusCount'
        ));
    }
}