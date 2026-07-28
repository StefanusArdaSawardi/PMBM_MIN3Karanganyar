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
     * Display the candidate queue (Menu: Penilaian)
     */
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
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereHas('nilaiUjian')
                ->count();

            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('nilaiUjian')
                ->count();

            // Hanya tampilkan yang BELUM diuji di halaman antrean utama
            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('nilaiUjian')
                ->with(['calonMurid', 'program'])
                ->get();
        } else {
            $telahDiujiCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereHas('wawancaraAnak')
                ->count();

            $antreanCount = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('wawancaraAnak')
                ->count();

            // Hanya tampilkan yang BELUM diwawancara di halaman antrean utama
            $queue = Pendaftaran::where(function ($q) use ($periodFilter) { $periodFilter($q); })
                ->whereDoesntHave('wawancaraAnak')
                ->with(['calonMurid', 'program'])
                ->get();
        }

        return view('dashboard.panitia', compact('telahDiujiCount', 'antreanCount', 'queue', 'role', 'activePeriod'));
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

        // Mengambil data siswa yang SUDAH dinilai/diwawancarai
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

        return view('dashboard.panitia-hasil-nilai', compact('students', 'role', 'activePeriod'));
    }
}