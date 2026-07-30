<?php

namespace App\Http\Controllers;

use App\Models\PanitiaPmbm;
use App\Models\PeriodePendaftaran;
use App\Models\Program;
use Illuminate\Http\Request;

class PeriodePendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = PeriodePendaftaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $periodes = $query->orderBy('tahun', 'desc')->get();

        return view('pengaturan.periode.index', compact('periodes'));
    }

    public function create()
    {
        $programs = Program::all();
        $panitias = PanitiaPmbm::all();

        return view('pengaturan.periode.form', ['periode' => null, 'programs' => $programs, 'panitias' => $panitias]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'id_programs' => 'nullable|array',
            'id_programs.*' => 'exists:programs,id_program',
        ]);

        $validated['jumlah_program'] = count($request->input('id_programs', []));
        $validated['status'] = 'aktif';

        // Pastikan hanya satu periode aktif
        if ($validated['status'] === 'aktif') {
            PeriodePendaftaran::where('status', 'aktif')->update(['status' => 'nonaktif']);
        }

        $periode = PeriodePendaftaran::create($validated);
        $periode->programs()->sync($request->input('id_programs', []));

        return redirect()->route('tata_usaha.periode.index')->with('success', 'Periode pendaftaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periode = PeriodePendaftaran::with(['programs', 'koordinators'])->findOrFail($id);
        $programs = Program::all();
        $panitias = PanitiaPmbm::all();

        return view('pengaturan.periode.form', compact('periode', 'programs', 'panitias'));
    }

    public function update(Request $request, $id)
    {
        $periode = PeriodePendaftaran::findOrFail($id);

        $validated = $request->validate([
            'tahun' => 'required|digits:4|integer',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'id_programs' => 'nullable|array',
            'id_programs.*' => 'exists:programs,id_program',
        ]);

        $validated['jumlah_program'] = count($request->input('id_programs', []));

        // Pastikan hanya satu periode aktif
        if ($periode->status === 'aktif') {
            PeriodePendaftaran::where('status', 'aktif')->where('id', '!=', $periode->id)->update(['status' => 'nonaktif']);
        }

        $periode->update($validated);
        $periode->programs()->sync($request->input('id_programs', []));

        return redirect()->route('tata_usaha.periode.index')->with('success', 'Periode pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PeriodePendaftaran::findOrFail($id)->delete();

        return redirect()->route('tata_usaha.periode.index')->with('success', 'Periode pendaftaran berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $periode = PeriodePendaftaran::findOrFail($id);
        $periode->status = $periode->status === 'aktif' ? 'nonaktif' : 'aktif';
        $periode->save();

        return redirect()->route('tata_usaha.periode.index')->with('success', 'Status periode berhasil diperbarui.');
    }
}
