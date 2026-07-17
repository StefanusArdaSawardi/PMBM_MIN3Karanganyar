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
            'jenis_penilaian' => 'nullable|string|max:255',
            'threshold_nilai_min' => 'nullable|integer|min:0|max:100',
            'threshold_nilai_max' => 'nullable|integer|min:0|max:100|gte:threshold_nilai_min',
        ]);

        $validated['poin_unggulan'] = array_values(array_filter($validated['poin_unggulan'] ?? []));

        if ($request->hasFile('image')) {
            $validated['image'] = 'assets/programs/' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/programs'), basename($validated['image']));
        }

        Program::create($validated);

        return redirect()->route('tata_usaha.program.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);

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
            'jenis_penilaian' => 'nullable|string|max:255',
            'threshold_nilai_min' => 'nullable|integer|min:0|max:100',
            'threshold_nilai_max' => 'nullable|integer|min:0|max:100|gte:threshold_nilai_min',
        ]);

        $validated['poin_unggulan'] = array_values(array_filter($validated['poin_unggulan'] ?? []));

        if ($request->hasFile('image')) {
            if ($program->image && file_exists(public_path($program->image))) {
                @unlink(public_path($program->image));
            }
            $validated['image'] = 'assets/programs/' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('assets/programs'), basename($validated['image']));
        }

        $program->update($validated);

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
