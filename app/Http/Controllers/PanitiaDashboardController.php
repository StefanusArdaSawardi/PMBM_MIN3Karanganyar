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

        // ==========================================
        // 🚀 DYNAMIC SESSION DUMMY BYPASS FOR DEV MODE
        // ==========================================
        if ($queue->isEmpty() && !session()->has('dummy_initialized')) {
            session(['dummy_students' => [
                'PMB0001' => ['nama' => 'Achmad Fauzi Dummy', 'nisn' => '0098765432', 'program' => 'Reguler', 'status' => 'pending', 'nilai' => null],
                'PMB0002' => ['nama' => 'Siti Aminah Dummy', 'nisn' => '0091234567', 'program' => 'Tahfidz', 'status' => 'pending', 'nilai' => null]
            ]]);
            session(['dummy_initialized' => true]);
        }

        if (session()->has('dummy_students')) {
            $dummyStudents = session('dummy_students');
            $simulatedQueue = [];
            $simulatedTelahDiuji = 0;
            
            foreach ($dummyStudents as $id => $data) {
                if ($data['status'] === 'pending') {
                    $item = new \stdClass();
                    $item->id_pendaftaran = $id;
                    $item->calonMurid = (object)['nama_murid' => $data['nama'], 'nisn' => $data['nisn']];
                    $item->program = (object)['nama_program' => $data['program']];
                    $item->nilaiUjian = null;
                    $item->wawancaraAnak = null;
                    $simulatedQueue[] = $item;
                } else {
                    $simulatedTelahDiuji++;
                }
            }
            
            $queue = collect($simulatedQueue);
            $antreanCount = count($simulatedQueue);
            // Tambahkan nilai hitung asli database jika ada agar akurat
            $telahDiujiCount = $telahDiujiCount + $simulatedTelahDiuji; 
        }
        // ==========================================

        return view('dashboard.panitia', compact('telahDiujiCount', 'antreanCount', 'queue', 'role', 'activePeriod'));
    }

    public function detailUjian($id)
{
    try {
        $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'nilaiUjian'])->findOrFail($id);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // 🚀 BYPASS DUMMY DEV MODE (Ambil data + nilai yang tersimpan di session)
        $dummyStudents = session('dummy_students', []);
        $currentDummy = $dummyStudents[$id] ?? ['nama' => 'Achmad Fauzi Dummy', 'nisn' => '0098765432', 'program' => 'Reguler', 'nilai' => null];

        $pendaftaran = new \stdClass();
        $pendaftaran->id_pendaftaran = $id;
        $pendaftaran->calonMurid = (object)[
            'nama_murid' => $currentDummy['nama'], 
            'nisn' => $currentDummy['nisn'],
            'pas_foto' => null
        ];
        $pendaftaran->program = (object)[
            'nama_program' => $currentDummy['program']
        ];
        
        // Membaca nilai lama dari session agar terisi otomatis saat mode edit
        $pendaftaran->nilaiUjian = (object)[
            'nilai_hafalan'   => $currentDummy['nilai']['hafalan'] ?? null,
            'nilai_iqro'      => $currentDummy['nilai']['iqro'] ?? null,
            'nilai_calistung' => $currentDummy['nilai']['calistung'] ?? null
        ];
    }

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

        try {
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

            if ($pendaftaran->wawancaraAnak()->exists() && $pendaftaran->wawancaraOrtu()->exists()) {
                $pendaftaran->status_kelulusan = null;
                $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
                $pendaftaran->status = 'cek_kelulusan';
                $pendaftaran->save();
                
                \App\Services\DssService::recalculateAll();
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 🚀 INTERACTIVE DUMMY SAVING STATE WITHIN SESSION
            if (session()->has('dummy_students')) {
                $dummyStudents = session('dummy_students');
                if (isset($dummyStudents[$id])) {
                    $dummyStudents[$id]['status'] = 'success';
                    $dummyStudents[$id]['nilai'] = [
                        'hafalan' => $request->nilai_hafalan,
                        'iqro' => $request->nilai_iqro,
                        'calistung' => $request->nilai_calistung,
                    ];
                    session(['dummy_students' => $dummyStudents]);
                }
            }
            return redirect()->route('panitia.dashboard')->with('success_grading', 'Mode Dummy: Nilai simulasi berhasil diproses!');
        }

        return redirect()->route('panitia.dashboard')->with('success_grading', 'Seluruh instrumen nilai ujian berhasil disimpan!');
    }

    public function detailWawancara($id)
    {
        try {
            $pendaftaran = Pendaftaran::with(['calonMurid', 'program', 'wawancaraAnak', 'wawancaraOrtu'])->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // BYPASS INSTAN DATA DUMMY DEV MODE
            $dummyStudents = session('dummy_students', []);
            $currentDummy = $dummyStudents[$id] ?? ['nama' => 'Muhammad Arsyad', 'nisn' => '0098765432', 'program' => 'Reguler'];

            $pendaftaran = new \stdClass();
            $pendaftaran->id_pendaftaran = $id;
            $pendaftaran->calonMurid = (object)[
                'nama_murid' => 'Muhammad Arsyad', 
                'nisn' => $currentDummy['nisn'],
                'pas_foto' => null
            ];
            $pendaftaran->program = (object)[
                'nama_program' => $currentDummy['program']
            ];
            $pendaftaran->wawancaraAnak = (object)[
                'wawancara_aism' => null, 'wawancara_irqa' => null, 'wawancara_calistung' => null, 'wawancara_dikte' => null, 'wawancara_kemandirian' => null,
            ];
            $pendaftaran->wawancaraOrtu = (object)[
                'komitmen_ortu' => null
            ];
        }

        // Arahkan ke nama file page baru kita bro!
        return view('dashboard.panitia-wawancara-ortu', compact('pendaftaran'));
    }

    public function storeWawancara(Request $request, $id)
    {
        $request->validate([
            'komitmen_ortu' => 'required|string|max:1000',
        ]);

        try {
            $pendaftaran = Pendaftaran::findOrFail($id);
            $panitiaId = auth()->guard('panitia')->id() ?: 'PAN0001';

            WawancaraOrtu::updateOrCreate(
                ['id_pendaftaran' => $pendaftaran->id_pendaftaran],
                [
                    'id_panitia' => $panitiaId,
                    'komitmen_ortu' => $request->komitmen_ortu,
                ]
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // 🚀 UPDATE DUMMY STATE SESUAI GAMBAR FIGMA BARU
            if (session()->has('dummy_students')) {
                $dummyStudents = session('dummy_students');
                if (isset($dummyStudents[$id])) {
                    $dummyStudents[$id]['status'] = 'success';
                    $dummyStudents[$id]['wawancara_ortu'] = [
                        'komitmen' => $request->input('komitmen_status', 'Setuju'),
                        'dukungan' => $request->input('fasilitas_status', 'Setuju'),
                        'visimisi' => $request->input('visimisi_status', 'Setuju'),
                        'catatan'  => $request->komitmen_ortu,
                        'status_lulus' => 'LULUS' // Mock status: LULUS, CADANGAN, TIDAK LULUS
                    ];
                    session(['dummy_students' => $dummyStudents]);
                }
            }
            return redirect()->route('panitia.hasil-nilai')->with('success_grading', 'Hasil wawancara berhasil disimpan!');
        }

        return redirect()->route('panitia.hasil-nilai')->with('success_grading', 'Hasil wawancara berhasil disimpan!');
    }

    public function hasilNilai()
    {
        $panitia = auth()->guard('panitia')->user();
        $role = $panitia ? $panitia->role_panitia : 'petugas_wawancara';
        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();

        // ==========================================
        // 🚀 DYNAMIC DATA MAPPING SESUAI GAMBAR KEDUA (DEV MODE)
        // ==========================================
        $simulatedDone = [];
        
        // Inisialisasi data dummy awal di hasil jika belum ada yang diisi demi kecocokan gambar kedua
        if (!session()->has('dummy_students')) {
            session(['dummy_students' => [
                'PMB0001' => [
                    'nama' => 'CERIA LARAS FATMA', 'nisn' => '0098765432', 'program' => 'Reguler', 'status' => 'success',
                    'wawancara_ortu' => ['komitmen' => 'Setuju', 'dukungan' => 'Setuju', 'visimisi' => 'Setuju', 'status_lulus' => 'LULUS']
                ],
                'PMB0002' => [
                    'nama' => 'MUMTAZ REINO BARAK', 'nisn' => '0091234567', 'program' => 'Tahfidz', 'status' => 'success',
                    'wawancara_ortu' => ['komitmen' => 'Setuju', 'dukungan' => 'Setuju', 'visimisi' => 'Setuju', 'status_lulus' => 'CADANGAN']
                ],
                'PMB0003' => [
                    'nama' => 'ARSYAD AZZAM DUMMY', 'nisn' => '0095556667', 'program' => 'Fullday', 'status' => 'success',
                    'wawancara_ortu' => ['komitmen' => 'Setuju', 'dukungan' => 'Setuju', 'visimisi' => 'Setuju', 'status_lulus' => 'TIDAK LULUS']
                ]
            ]]);
        }

        if (session()->has('dummy_students')) {
            $dummyStudents = session('dummy_students');
            foreach ($dummyStudents as $id => $data) {
                if ($data['status'] === 'success') {
                    $dummyDone = new \stdClass();
                    $dummyDone->id_pendaftaran = $id;
                    $dummyDone->calonMurid = (object)['nama_murid' => $data['nama'], 'nisn' => $data['nisn']];
                    $dummyDone->wawancaraOrtu = (object)[
                        'komitmen' => $data['wawancara_ortu']['komitmen'] ?? 'Setuju',
                        'dukungan' => $data['wawancara_ortu']['dukungan'] ?? 'Setuju',
                        'visimisi' => $data['wawancara_ortu']['visimisi'] ?? 'Setuju',
                        'status_lulus' => $data['wawancara_ortu']['status_lulus'] ?? 'LULUS'
                    ];
                    $simulatedDone[] = $dummyDone;
                }
            }
        }

        $students = collect($simulatedDone);
        return view('dashboard.panitia-hasil-nilai', compact('students', 'role', 'activePeriod'));
    }
}