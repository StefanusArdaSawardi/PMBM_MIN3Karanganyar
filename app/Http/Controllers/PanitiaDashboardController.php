<?php

namespace App\Http\Controllers;

use App\Models\CalonMurid;
use App\Models\HasilWawancaraDanUjian;
use Illuminate\Http\Request;

class PanitiaDashboardController extends Controller
{
    /**
     * Display the interview queue.
     */
    public function index()
    {
        // Count how many have been evaluated (having interview score)
        $telahDiujiCount = HasilWawancaraDanUjian::whereNotNull('nilai_wawancara')->count();

        // Count how many are still pending / not evaluated yet
        $antreanCount = CalonMurid::whereDoesntHave('hasil', function($q) {
            $q->whereNotNull('nilai_wawancara');
        })->count();

        // Get queue of all candidates with their registration details and existing scores
        $queue = CalonMurid::with(['pendaftaran.program', 'hasil'])->get();

        return view('dashboard.panitia', compact('telahDiujiCount', 'antreanCount', 'queue'));
    }

    /**
     * Show grading panel for a student.
     */
    public function detail($id)
    {
        $student = CalonMurid::with(['pendaftaran.program', 'hasil'])->findOrFail($id);

        return view('dashboard.panitia-grading', compact('student'));
    }

    /**
     * Store candidate score and comments.
     */
    public function storeGrading(Request $request, $id)
    {
        $request->validate([
            'nilai_hafalan' => 'required|integer|between:1,100',
            'nilai_wawancara' => 'required|integer|between:1,100',
            'nilai_calistung' => 'required|integer|between:1,100',
            'nilai_tasmi' => 'required|integer|between:1,100',
            'nilai_mandiri' => 'required|integer|between:1,100',
            'rating_ortu' => 'required|integer|between:1,10',
            'catatan' => 'nullable|string',
        ]);

        $student = CalonMurid::with('pendaftaran')->findOrFail($id);

        // Retrieve current authenticated panitia ID (guard: panitia)
        $panitiaId = auth()->guard('panitia')->id() ?: 1;

        // Check if there is already a result record for this student
        $hasil = HasilWawancaraDanUjian::where('id_murid', $id)->first();
        if (!$hasil) {
            $hasil = new HasilWawancaraDanUjian();
        }

        $hasil->id_murid = $student->id_murid;
        $hasil->id_ayah = $student->id_ayah;
        $hasil->id_ibu = $student->id_ibu;
        $hasil->id_program = $student->pendaftaran->id_program;
        $hasil->id_panitia = $panitiaId;
        
        $hasil->nilai_hafalan = $request->nilai_hafalan;
        $hasil->nilai_wawancara = $request->nilai_wawancara;
        $hasil->nilai_calistung = $request->nilai_calistung;
        $hasil->nilai_tasmi = $request->nilai_tasmi;
        $hasil->nilai_mandiri = $request->nilai_mandiri;
        
        // Calculate average for nilai_ujian (legacy compatibility)
        $hasil->nilai_ujian = round(
            ($request->nilai_hafalan + $request->nilai_wawancara + $request->nilai_calistung + $request->nilai_tasmi + $request->nilai_mandiri) / 5
        );
        
        // Save manual comment
        $hasil->catatan_manual = $request->catatan;

        // Calculate dynamic final score and generate narrative
        $config = \App\Services\DssService::getConfig();
        $program = \App\Models\Program::find($hasil->id_program);
        $weights = ($program && $program->dss_weights) ? $program->dss_weights : ($config['weights'] ?? [
            'hafalan' => 30,
            'wawancara' => 20,
            'calistung' => 20,
            'tasmi' => 15,
            'mandiri' => 15
        ]);

        $nilaiAkhir = (
            ($request->nilai_hafalan * ($weights['hafalan'] ?? 30)) +
            ($request->nilai_wawancara * ($weights['wawancara'] ?? 20)) +
            ($request->nilai_calistung * ($weights['calistung'] ?? 20)) +
            ($request->nilai_tasmi * ($weights['tasmi'] ?? 15)) +
            ($request->nilai_mandiri * ($weights['mandiri'] ?? 15))
        ) / 100;

        $scores = [
            'hafalan' => $request->nilai_hafalan,
            'wawancara' => $request->nilai_wawancara,
            'calistung' => $request->nilai_calistung,
            'tasmi' => $request->nilai_tasmi,
            'mandiri' => $request->nilai_mandiri
        ];

        $hasil->catatan_otomatis = \App\Services\DssService::generateNarrative($scores, $config);
        $hasil->nilai_akhir = $nilaiAkhir;

        // Combined comment
        $hasil->catatan = $hasil->catatan_otomatis . ($request->catatan ? "\n\nCatatan Penguji: " . $request->catatan : "");
        $hasil->save();

        // Run mass recommendation engine recalculation
        \App\Services\DssService::recalculateAll();

        return redirect()->route('panitia.dashboard')->with('success_grading', 'Penilaian untuk ' . $student->nama_murid . ' berhasil disimpan!');
    }
}
