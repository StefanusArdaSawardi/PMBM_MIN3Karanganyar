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
            $query->where('status_verifikasi', 'terverifikasi_onsite');
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
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })->whereHas('wawancaraAnak')->count();
            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })->whereDoesntHave('wawancaraAnak')->count();
            
            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('wawancaraAnak')
                ->with(['calonMurid', 'program'])
                ->get();
        }

        if ($queue->isEmpty()) {
            
            $dummy1 = new \stdClass();
            $dummy1->id_pendaftaran = 'PMB0001';
            $dummy1->calonMurid = (object)['nama_murid' => 'Achmad Fauzi Dummy', 'nisn' => '0098765432'];
            $dummy1->program = (object)['nama_program' => 'Reguler'];
            $dummy1->nilaiUjian = null;
            $dummy1->wawancaraAnak = null;

            $dummy2 = new \stdClass();
            $dummy2->id_pendaftaran = 'PMB0002';
            $dummy2->calonMurid = (object)['nama_murid' => 'Siti Aminah Dummy', 'nisn' => '0091234567'];
            $dummy2->program = (object)['nama_program' => 'Tahfidz'];
            $dummy2->nilaiUjian = null;
            $dummy2->wawancaraAnak = null;

            $queue = collect([$dummy1, $dummy2]);
            $antreanCount = 2;
        }

        return view('dashboard.panitia', compact('telahDiujiCount', 'antreanCount', 'queue', 'role', 'activePeriod'));
    }


        public function detailUjian($id)
    {
        // Kita coba cari di database dulu, kalau tidak ada (karena pakai data dummy/dev mode), kita bypass!
        try {
            $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'nilaiUjian'])->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 🚀 BYPASS INSTAN KHUSUS DEVELOPMENT/DUMMY MODE
            $pendaftaran = new \stdClass();
            $pendaftaran->id_pendaftaran = $id; // Akan bernilai 'PMB0001'
            $pendaftaran->calonMurid = (object)[
                'nama_murid' => 'Achmad Fauzi Dummy', 
                'nisn' => '0098765432',
                'pas_foto' => null // Set path foto jika ada, misal: 'assets/foto.jpg'
            ];
            $pendaftaran->program = (object)[
                'nama_program' => 'Reguler'
            ];
            $pendaftaran->nilaiUjian = (object)[
                'nilai_hafalan' => null,
                'nilai_iqro' => null,
                'nilai_calistung' => null
            ];
        }

        return view('dashboard.panitia-grading-ujian', compact('pendaftaran'));
    }
    /**
     * Store exam scores (integer 1-100).
     */
    public function storeUjian(Request $request, $id)
    {
        // 1. Validasi data input
        $request->validate([
            'nilai_hafalan'     => 'required|integer|between:1,100',
            'nilai_aism'        => 'nullable|integer|between:1,100',
            'nilai_iqro'        => 'required|integer|between:1,100',
            'nilai_calistung'   => 'required|integer|between:1,100',
            'nilai_dikte'       => 'nullable|integer|between:1,100',
            'nilai_kemandirian' => 'nullable|integer|between:1,100',
        ]);

        try {
            // Cari data asli di database
            $pendaftaran = Pendaftaran::findOrFail($id);
            $panitiaId = auth()->guard('panitia')->id() ?: 'PAN0001';

            // Simpan ke database asli
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

            if ($pendaftaran->wawancaraAnak()->exists() && $pendaftaran->wawancaraOrtu()->exists()) {
                $pendaftaran->status_kelulusan = null;
                $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
                $pendaftaran->status = 'cek_kelulusan';
                $pendaftaran->save();
                
                \App\Services\DssService::recalculateAll();
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 🚀 BYPASS KHUSUS DUMMY MODE (Jika data PMB0001 tidak ada di database)
            // Kita tidak menyimpan ke database, tapi langsung melempar redirect sukses ke dashboard utama
            return redirect()->route('panitia.dashboard')->with('success_grading', 'Mode Dummy: Nilai simulasi berhasil diproses!');
        }

        return redirect()->route('panitia.dashboard')->with('success_grading', 'Seluruh instrumen nilai ujian berhasil disimpan!');
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

    public function hasilNilai()
    {
        $panitia = auth()->guard('panitia')->user();
        $role = $panitia ? $panitia->role_panitia : 'pengawas_ujian';
        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();

        $periodFilter = function ($query) use ($activePeriod) {
            $query->where('status_verifikasi', 'terverifikasi_onsite');
            if ($activePeriod) {
                $query->where('periode_pendaftaran_id', $activePeriod->id);
            }
        };

        // Mengambil data asli dari database jika ada
        if ($role === 'pengawas_ujian') {
            $students = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereHas('nilaiUjian')
                ->with(['calonMurid', 'program', 'nilaiUjian'])
                ->get();
        } else {
            $students = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereHas('wawancaraAnak')
                ->with(['calonMurid', 'program', 'wawancaraAnak', 'nilaiUjian'])
                ->get();
        }

        // ==========================================
        // 🚀 BYPASS DUMMY KHUSUS UNTUK HASIL NILAI (DEV MODE)
        // ==========================================
        if ($students->isEmpty()) {
            $dummyDone = new \stdClass();
            $dummyDone->id_pendaftaran = 'PMB0001';
            $dummyDone->calonMurid = (object)['nama_murid' => 'Achmad Fauzi Dummy', 'nisn' => '0098765432'];
            $dummyDone->program = (object)['nama_program' => 'Reguler'];
            $dummyDone->nilaiUjian = (object)[
                'nilai_hafalan' => 85,
                'nilai_iqro' => 80,
                'nilai_calistung' => 90
            ];
            
            $students = collect([$dummyDone]);
        }
        // ==========================================

        return view('dashboard.panitia-hasil-nilai', compact('students', 'role', 'activePeriod'));
    }
}
