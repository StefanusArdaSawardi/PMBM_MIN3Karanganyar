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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'criteria' => 'nullable|array',
            'criteria.*.nama_kriteria' => 'required|string|in:hafalan,aism,iqro,calistung,dikte,kemandirian',
            'criteria.*.nilai_minimum' => 'required|integer|min:0|max:100',
        ]);

        $validated['poin_unggulan'] = array_values(array_filter($validated['poin_unggulan'] ?? []));

        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = 'assets/programs/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/programs'), basename($path));
                $newImages[] = $path;
            }
        }
        $validated['image'] = count($newImages) > 0 ? json_encode($newImages) : null;

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

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'persyaratan' => 'required|string',
            'poin_unggulan' => 'nullable|array',
            'poin_unggulan.*' => 'nullable|string|max:255',
            'kuota_program' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'criteria' => 'nullable|array',
            'criteria.*.nama_kriteria' => 'required|string|in:hafalan,aism,iqro,calistung,dikte,kemandirian',
            'criteria.*.nilai_minimum' => 'required|integer|min:0|max:100',
        ]);

        $validated = $request->only(['nama_program', 'persyaratan', 'poin_unggulan', 'kuota_program']);
        $validated['poin_unggulan'] = array_values(array_filter($validated['poin_unggulan'] ?? []));

        // Preserve current images
        $existing = $request->input('existing_images', []);
        
        // Find deleted images and clean from disk
        $oldImages = $program->images;
        $deletedImages = array_diff($oldImages, $existing);
        foreach ($deletedImages as $delImg) {
            if ($delImg && file_exists(public_path($delImg))) {
                @unlink(public_path($delImg));
            }
        }

        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = 'assets/programs/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/programs'), basename($path));
                $newImages[] = $path;
            }
        }

        $finalImages = array_merge($existing, $newImages);
        $validated['image'] = count($finalImages) > 0 ? json_encode($finalImages) : null;

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

        foreach ($program->images as $img) {
            if ($img && file_exists(public_path($img))) {
                @unlink(public_path($img));
            }
        }

        $program->delete();

        DssService::recalculateAll();

        return redirect()->route('tata_usaha.program.index')->with('success', 'Program berhasil dihapus.');
    }
}
