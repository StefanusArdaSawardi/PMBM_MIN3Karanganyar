<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\CalonMurid;
use App\Models\AyahCalonMurid;
use App\Models\IbuCalonMurid;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $programs = Program::all();

        $contentPath = storage_path('app/landing_content.json');
        $landingContent = [];
        if (file_exists($contentPath)) {
            $landingContent = json_decode(file_get_contents($contentPath), true) ?? [];
        }

        return view('landing.home', compact('programs', 'landingContent'));
    }

    /**
     * Display the Program Khusus page.
     */
    public function programKhusus()
    {
        return view('landing.program-khusus');
    }

    /**
     * Display the Program Unggulan page.
     */
    public function programUnggulan()
    {
        return view('landing.program-unggulan');
    }

    /**
     * Display the Program Fullday page.
     */
    public function programFullday()
    {
        return view('landing.program-fullday');
    }

    /**
     * Display the Contact page.
     */
    public function kontak()
    {
        return view('landing.kontak');
    }

    /**
     * Display the Guide page.
     */
    public function guide()
    {
        return view('landing.guide');
    }

    /**
     * Display the Cek Status page.
     */
    public function cekKelulusan()
    {
        return view('landing.cek-kelulusan');
    }

    /**
     * Check student graduation status.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'nama_murid' => 'required|string',
        ]);

        $nisn = trim($request->input('nisn'));
        $namaMurid = trim($request->input('nama_murid'));

        // Run waitlist cleanup
        \App\Models\Pendaftaran::where('status_kelulusan', 'cadangan')
            ->where('updated_at', '<', now()->subWeek())
            ->update(['status_kelulusan' => 'tidak_lulus']);

        $pendaftaran = Pendaftaran::whereHas('calonMurid', function ($query) use ($nisn, $namaMurid) {
                $query->where('nisn', $nisn)
                    ->where('nama_murid', 'like', '%' . $namaMurid . '%');
            })
            ->first();

        if (!$pendaftaran) {
            return back()->with('error', 'NISN atau Nama Calon Murid tidak ditemukan.');
        }

        // Store verification in session so they can edit their registration details securely
        session(['verified_pendaftaran_id' => $pendaftaran->id_pendaftaran]);

        $student = $pendaftaran->calonMurid;
        return view('landing.hasil-kelulusan', compact('pendaftaran', 'student'));
    }

    /**
     * Show registration form.
     */
    public function showRegisterForm()
    {
        $programs = Program::all();
        return view('pendaftaran.register', compact('programs'));
    }

    /**
     * Show edit registration form.
     */
    public function editRegisterForm($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        
        if (session('verified_pendaftaran_id') != $id) {
            abort(403, 'Sesi verifikasi pendaftaran tidak valid. Silakan cek status pendaftaran Anda kembali.');
        }
 
        if ($pendaftaran->status_verifikasi !== 'ditolak') {
            abort(403, 'Pendaftaran Anda tidak dalam status Berkas Ditolak, sehingga data tidak dapat diubah.');
        }
 
        $student = $pendaftaran->calonMurid;
        $ayah = $student->ayah;
        $ibu = $student->ibu;
        $programs = Program::all();
 
        return view('pendaftaran.edit', compact('pendaftaran', 'student', 'ayah', 'ibu', 'programs'));
    }

    /**
     * Update registration data.
     */
    public function updateRegisterForm(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
 
        if (session('verified_pendaftaran_id') != $id) {
            abort(403, 'Sesi verifikasi pendaftaran tidak valid.');
        }
 
        if ($pendaftaran->status_verifikasi !== 'ditolak') {
            abort(403, 'Pendaftaran Anda tidak dalam status Berkas Ditolak.');
        }
 
        $request->validate([
            // Student Data
            'nama_murid' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\,]+$/'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'nisn' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/'],
            'id_program' => 'required|exists:programs,id_program',
            'tempat_lahir' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'required|string|min:10',
            'email' => 'required|email|max:100',

            // Father Data
            'nama_ayah' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\,]+$/'],
            'pekerjaan_ayah' => 'nullable|string|min:3|max:100',
            'nomor_telpon_ayah' => ['nullable', 'string', 'regex:/^(08|62)[0-9]{8,13}$/'],

            // Mother Data
            'nama_ibu' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\,]+$/'],
            'pekerjaan_ibu' => 'nullable|string|min:3|max:100',
            'nomor_telpon_ibu' => ['nullable', 'string', 'regex:/^(08|62)[0-9]{8,13}$/'],

            // Kejuaraan
            'piagram_kejuaraan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Files (all nullable on edit)
            'pas_foto' => 'nullable|file|image|max:5120',
            'kartu_keluarga' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'akta_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'kartu_identitas_anak' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nama_murid.min' => 'Nama murid minimal 3 karakter.',
            'nama_murid.regex' => 'Nama murid hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nik.size' => 'NIK harus tepat 16 digit angka.',
            'nik.regex' => 'NIK harus berupa 16 digit angka.',
            'nisn.size' => 'NISN harus tepat 10 digit angka.',
            'nisn.regex' => 'NISN harus berupa 10 digit angka (tanpa huruf/simbol).',
            'tempat_lahir.min' => 'Tempat lahir minimal 3 karakter.',
            'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'alamat.min' => 'Alamat terlalu pendek, minimal 10 karakter.',
            'nama_ayah.min' => 'Nama ayah minimal 3 karakter.',
            'nama_ayah.regex' => 'Nama ayah hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nama_ibu.min' => 'Nama ibu minimal 3 karakter.',
            'nama_ibu.regex' => 'Nama ibu hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nomor_telpon_ayah.regex' => 'No. telpon ayah harus format Indonesia (08xxx atau 62xxx), 10-15 digit.',
            'nomor_telpon_ibu.regex' => 'No. telpon ibu harus format Indonesia (08xxx atau 62xxx), 10-15 digit.',
        ]);
 
        $student = $pendaftaran->calonMurid;
        $ayah = $student->ayah;
        $ibu = $student->ibu;
 
        // Update Father
        $ayah->update([
            'nama_ayah' => $request->nama_ayah,
            'pekerjaan' => $request->pekerjaan_ayah,
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon_ayah,
        ]);
 
        // Update Mother
        $ibu->update([
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan' => $request->pekerjaan_ibu,
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon_ibu,
        ]);
 
        // Handle piagam kejuaraan upload
        $piagamPath = $student->piagram_kejuaraan;
        if ($request->hasFile('piagram_kejuaraan')) {
            // Delete old piagam if exists
            if ($student->piagram_kejuaraan && file_exists(public_path($student->piagram_kejuaraan))) {
                @unlink(public_path($student->piagram_kejuaraan));
            }
            $file = $request->file('piagram_kejuaraan');
            $filename = time() . '_piagram_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents'), $filename);
            $piagamPath = '/uploads/documents/' . $filename;
        }

        // Handle file uploads
        $files = [];
        $documentFields = ['pas_foto', 'kartu_keluarga', 'akta_kelahiran', 'kartu_identitas_anak'];
        
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($student->$field && file_exists(public_path($student->$field))) {
                    @unlink(public_path($student->$field));
                }
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents'), $filename);
                $files[$field] = '/uploads/documents/' . $filename;
            } else {
                $files[$field] = $student->$field;
            }
        }
 
        // Update Student
        $student->update([
            'nama_murid' => $request->nama_murid,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'nisn' => $request->nisn,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'pas_foto' => $files['pas_foto'],
            'kartu_keluarga' => $files['kartu_keluarga'],
            'akta_kelahiran' => $files['akta_kelahiran'],
            'kartu_identitas_anak' => $files['kartu_identitas_anak'],
            'piagram_kejuaraan' => $piagamPath,
        ]);
 
        // Update Pendaftaran status to Pending (Baru / Perubahan Data) and clear rejection reason
        $pendaftaran->update([
            'status_verifikasi' => 'menunggu_verifikasi',
            'id_program' => $request->id_program,
            'alasan_penolakan' => null,
        ]);
 
        return redirect()->route('landing.cek-kelulusan')->with('success_edit', 'Data pendaftaran Anda berhasil diperbarui dan berkas dikirim kembali untuk diverifikasi.');
    }

    /**
     * Store registration data.
     */
    public function storeRegisterForm(Request $request)
    {
        $request->validate([
            // Student Data
            'nama_murid' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\,]+$/'],
            'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'nisn' => ['required', 'string', 'size:10', 'regex:/^[0-9]{10}$/'],
            'id_program' => 'required|exists:programs,id_program',
            'tempat_lahir' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'required|string|min:10',
            'email' => 'required|email|max:100',

            // Father Data
            'nama_ayah' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\,]+$/'],
            'pekerjaan_ayah' => 'nullable|string|min:3|max:100',
            'nomor_telpon_ayah' => ['nullable', 'string', 'regex:/^(08|62)[0-9]{8,13}$/'],

            // Mother Data
            'nama_ibu' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\,]+$/'],
            'pekerjaan_ibu' => 'nullable|string|min:3|max:100',
            'nomor_telpon_ibu' => ['nullable', 'string', 'regex:/^(08|62)[0-9]{8,13}$/'],
 
            // Kejuaraan
            'piagram_kejuaraan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Files
            'pas_foto' => 'nullable|file|image|max:5120',
            'kartu_keluarga' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'akta_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'kartu_identitas_anak' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            // Custom error messages in Bahasa Indonesia
            'nama_murid.min' => 'Nama murid minimal 3 karakter.',
            'nama_murid.regex' => 'Nama murid hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nik.size' => 'NIK harus tepat 16 digit angka.',
            'nik.regex' => 'NIK harus berupa 16 digit angka.',
            'nisn.size' => 'NISN harus tepat 10 digit angka.',
            'nisn.regex' => 'NISN harus berupa 10 digit angka (tanpa huruf/simbol).',
            'tempat_lahir.min' => 'Tempat lahir minimal 3 karakter.',
            'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf dan spasi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'alamat.min' => 'Alamat terlalu pendek, minimal 10 karakter.',
            'nama_ayah.min' => 'Nama ayah minimal 3 karakter.',
            'nama_ayah.regex' => 'Nama ayah hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nama_ibu.min' => 'Nama ibu minimal 3 karakter.',
            'nama_ibu.regex' => 'Nama ibu hanya boleh berisi huruf, spasi, titik, dan koma.',
            'nomor_telpon_ayah.regex' => 'No. telpon ayah harus format Indonesia (08xxx atau 62xxx), 10-15 digit.',
            'nomor_telpon_ibu.regex' => 'No. telpon ibu harus format Indonesia (08xxx atau 62xxx), 10-15 digit.',
        ]);
 
        // Create Father
        $ayah = AyahCalonMurid::create([
            'nama_ayah' => $request->nama_ayah,
            'pekerjaan' => $request->pekerjaan_ayah,
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon_ayah,
        ]);
 
        // Create Mother
        $ibu = IbuCalonMurid::create([
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan' => $request->pekerjaan_ibu,
            'alamat' => $request->alamat,
            'nomor_telpon' => $request->nomor_telpon_ibu,
        ]);
 
        // Handle piagam kejuaraan upload
        $piagamPath = null;
        if ($request->hasFile('piagram_kejuaraan')) {
            $file = $request->file('piagram_kejuaraan');
            $filename = time() . '_piagram_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents'), $filename);
            $piagamPath = '/uploads/documents/' . $filename;
        }

        // Upload documents helper
        $files = [];
        $documentFields = ['pas_foto', 'kartu_keluarga', 'akta_kelahiran', 'kartu_identitas_anak'];
        
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents'), $filename);
                $files[$field] = '/uploads/documents/' . $filename;
            } else {
                $files[$field] = null;
            }
        }
 
        // Create Student
        $student = CalonMurid::create([
            'nama_murid' => $request->nama_murid,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'nisn' => $request->nisn,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'id_ayah' => $ayah->id_ayah,
            'id_ibu' => $ibu->id_ibu,
            'piagram_kejuaraan' => $piagamPath,
            'pas_foto' => $files['pas_foto'],
            'kartu_keluarga' => $files['kartu_keluarga'],
            'akta_kelahiran' => $files['akta_kelahiran'],
            'kartu_identitas_anak' => $files['kartu_identitas_anak'],
        ]);
 
        // Create Registration
        $pendaftaran = Pendaftaran::create([
            'tanggal_pendaftaran' => now(),
            'status_verifikasi' => 'menunggu_verifikasi',
            'id_murid' => $student->id_murid,
            'id_program' => $request->id_program,
        ]);
 
        $regNumber = 'PMB-2026-' . str_pad($pendaftaran->id_pendaftaran, 3, '0', STR_PAD_LEFT);
 
        return redirect()->route('student.register')->with('success', $regNumber);
    }
 
    /**
     * Return active FAQs in JSON format for the Chatbot.
     */
    public function getFaqsJson()
    {
        $faqs = \App\Models\Faq::orderBy('created_at', 'asc')->get();
        return response()->json($faqs);
    }
}
