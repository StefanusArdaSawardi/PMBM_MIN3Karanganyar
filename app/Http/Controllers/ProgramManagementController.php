<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Services\DssService;
use Illuminate\Http\Request;

class ProgramManagementController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('id_program')->get();

        return view('pengaturan.program.index', compact('programs'));
    }

    public function create()
    {
        // Run any pending migrations automatically
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {}

        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Exception $e) {}
        return view('pengaturan.program.form', ['program' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'persyaratan' => 'required|string',
            'poin_unggulan' => 'nullable|array',
            'poin_unggulan.*' => 'nullable|string|max:255',
            'kuota_program' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'criteria' => 'nullable|array',
            'criteria.*.nama_kriteria' => 'required|string|in:hafalan,aism,iqro,calistung,dikte,kemandirian',
            'criteria.*.nilai_minimum' => 'required|integer|min:0|max:100',
        ]);

        $validated['poin_unggulan'] = array_values(array_filter($validated['poin_unggulan'] ?? []));

        if ($request->hasFile('image')) {
            $validated['image'] = 'assets/programs/' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/programs'), basename($validated['image']));
        }

        // Reset obsolete single values
        $validated['jenis_penilaian'] = null;
        $validated['threshold_nilai_min'] = null;
        $validated['threshold_nilai_max'] = null;

        $program = Program::create($validated);

        if (!empty($request->criteria)) {
            foreach ($request->criteria as $crit) {
                if (!empty($crit['nama_kriteria'])) {
                    $program->criteria()->create([
                        'nama_kriteria' => $crit['nama_kriteria'],
                        'nilai_minimum' => $crit['nilai_minimum'] ?? 0,
                    ]);
                }
            }
        }

        // Recalculate rankings based on new criteria
        DssService::recalculateAll();

        return redirect()->route('tata_usaha.program.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Run any pending migrations automatically
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {}

        $program = Program::findOrFail($id);
        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Exception $e) {}
        return view('pengaturan.program.form', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'persyaratan' => 'required|string',
            'poin_unggulan' => 'nullable|array',
            'poin_unggulan.*' => 'nullable|string|max:255',
            'kuota_program' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'criteria' => 'nullable|array',
            'criteria.*.nama_kriteria' => 'required|string|in:hafalan,aism,iqro,calistung,dikte,kemandirian',
            'criteria.*.nilai_minimum' => 'required|integer|min:0|max:100',
        ]);

        $validated['poin_unggulan'] = array_values(array_filter($validated['poin_unggulan'] ?? []));

        if ($request->hasFile('image')) {
            if ($program->image && file_exists(public_path($program->image))) {
                @unlink(public_path($program->image));
            }
            $validated['image'] = 'assets/programs/' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/programs'), basename($validated['image']));
        }

        // Reset obsolete single values
        $validated['jenis_penilaian'] = null;
        $validated['threshold_nilai_min'] = null;
        $validated['threshold_nilai_max'] = null;

        $program->update($validated);

        // Delete old criteria and save new ones
        $program->criteria()->delete();

        if (!empty($request->criteria)) {
            foreach ($request->criteria as $crit) {
                if (!empty($crit['nama_kriteria'])) {
                    $program->criteria()->create([
                        'nama_kriteria' => $crit['nama_kriteria'],
                        'nilai_minimum' => $crit['nilai_minimum'] ?? 0,
                    ]);
                }
            }
        }

        // Recalculate rankings based on new threshold criteria
        DssService::recalculateAll();

        return redirect()->route('tata_usaha.program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        if ($program->image && file_exists(public_path($program->image))) {
            @unlink(public_path($program->image));
        }

        $program->delete();

        DssService::recalculateAll();

        return redirect()->route('tata_usaha.program.index')->with('success', 'Program berhasil dihapus.');
    }
}
