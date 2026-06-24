<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Program;
use App\Models\CalonMurid;
use App\Models\PengurusTataUsaha;
use App\Models\PanitiaPmbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard stats.
     */
    public function index()
    {
        $this->autoExpireWaitlists();

        $totalPeserta = Pendaftaran::count();
        $totalTidakKeterima = Pendaftaran::whereIn('status', ['Tidak Lulus', 'Berkas Ditolak', 'Mengundurkan Diri', 'Ditolak'])->count();
        $totalKeterima = Pendaftaran::whereIn('status', ['Lulus', 'Diterima', 'Diterima di Program Pilihan'])->count();
        $tingkatKelulusan = ($totalPeserta > 0) ? round(($totalKeterima / $totalPeserta) * 100) : 0;

        // Group chart counts by year dynamically
        $years = [now()->year - 2, now()->year - 1, now()->year];
        $charts = [
            'pendaftar' => [],
            'keterima' => []
        ];
        
        foreach ($years as $year) {
            $charts['pendaftar'][$year] = Pendaftaran::whereYear('tanggal_pendaftaran', $year)->count();
            $charts['keterima'][$year] = Pendaftaran::whereYear('tanggal_pendaftaran', $year)
                ->whereIn('status', ['Lulus', 'Diterima', 'Diterima di Program Pilihan'])
                ->count();
        }

        return view('dashboard.admin', compact('totalPeserta', 'totalTidakKeterima', 'totalKeterima', 'tingkatKelulusan', 'charts'));
    }

    /**
     * List applicants with filters.
     */
    public function applicants(Request $request)
    {
        $this->autoExpireWaitlists();
        $programs = Program::all();
        
        $query = Pendaftaran::with(['calonMurid.ibu', 'program']);

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Program Study
        if ($request->filled('program')) {
            $query->where('id_program', $request->program);
        }

        // Filter by Year
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pendaftaran', $request->tahun);
        }

        // Limit results
        $limit = $request->integer('limit', 10);
        if (!in_array($limit, [5, 10, 20, 30])) {
            $limit = 10;
        }

        $pendaftarans = $query->orderBy('created_at', 'desc')->take($limit)->get();

        return view('pendaftaran.index', compact('pendaftarans', 'programs', 'limit'));
    }

    /**
     * View specific applicant profile.
     */
    public function detail($id)
    {
        $this->autoExpireWaitlists();
        $pendaftaran = Pendaftaran::with(['calonMurid.ayah', 'calonMurid.ibu', 'program'])
            ->findOrFail($id);
        
        $student = $pendaftaran->calonMurid;

        return view('profile.show', compact('pendaftaran', 'student'));
    }

    /**
     * Update pendaftaran status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Berkas Diterima,Berkas Ditolak,Berkas Onsite Diterima,Lulus,Tidak Lulus,Cadangan,Diterima,Mengundurkan Diri,Diterima di Program Pilihan,Pindahkan ke Program Reguler,Ditolak',
            'alasan_ditolak' => 'nullable|string|max:1000'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $currentStatus = $pendaftaran->status;
        $nextStatus = $request->status;

        // Transition logic validation
        $isValidTransition = false;

        if ($currentStatus === $nextStatus) {
            $isValidTransition = true;
        } else {
            switch ($currentStatus) {
                case 'Pending':
                    if (in_array($nextStatus, ['Berkas Diterima', 'Berkas Ditolak'])) {
                        $isValidTransition = true;
                    }
                    break;
                case 'Berkas Ditolak':
                    if ($nextStatus === 'Berkas Diterima') {
                        $isValidTransition = true;
                    }
                    break;
                case 'Berkas Diterima':
                    if ($nextStatus === 'Berkas Onsite Diterima') {
                        $isValidTransition = true;
                    }
                    break;
                case 'Berkas Onsite Diterima':
                    if (in_array($nextStatus, ['Lulus', 'Tidak Lulus', 'Cadangan', 'Diterima di Program Pilihan', 'Pindahkan ke Program Reguler', 'Ditolak'])) {
                        $isValidTransition = true;
                    }
                    break;
                case 'Diterima di Program Pilihan':
                case 'Pindahkan ke Program Reguler':
                case 'Lulus':
                case 'Cadangan':
                    if (in_array($nextStatus, ['Diterima', 'Mengundurkan Diri', 'Diterima di Program Pilihan', 'Pindahkan ke Program Reguler', 'Ditolak'])) {
                        $isValidTransition = true;
                    }
                    break;
                case 'Ditolak':
                case 'Tidak Lulus':
                    if (in_array($nextStatus, ['Diterima di Program Pilihan', 'Pindahkan ke Program Reguler', 'Diterima', 'Mengundurkan Diri'])) {
                        $isValidTransition = true;
                    }
                    break;
            }
        }

        if (!$isValidTransition) {
            return back()->with('error', "Transisi status dari {$currentStatus} ke {$nextStatus} tidak diperbolehkan.");
        }

        // Additional validation
        if ($nextStatus === 'Berkas Ditolak' && !$request->filled('alasan_ditolak')) {
            return back()->with('error', "Harap masukkan alasan penolakan berkas.");
        }

        $pendaftaran->status = $nextStatus;
        if ($nextStatus === 'Berkas Ditolak') {
            $pendaftaran->alasan_ditolak = $request->alasan_ditolak;
        } else {
            $pendaftaran->alasan_ditolak = null; // Clear reason if transitioned away
        }
        $pendaftaran->save();

        return redirect()->route('tata_usaha.detail', $id)->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * Preview uploaded document.
     */
    public function previewDocument($type, $filename)
    {
        $path = public_path('uploads/documents/' . $filename);
        if (!file_exists($path)) {
            $path = public_path('documents/' . $filename);
        }

        if (file_exists($path)) {
            return response()->file($path);
        }

        abort(404, 'File berkas tidak ditemukan.');
    }

    /**
     * Manage landing page content (show).
     */
    public function showContent()
    {
        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        $programs = Program::all();
        $settings = $content; // map settings to the same content payload
        $dssConfig = \App\Services\DssService::getConfig();

        return view('master.landing', compact('content', 'settings', 'programs', 'dssConfig'));
    }

    /**
     * Update landing page texts.
     */
    public function updateContentText(Request $request)
    {
        $request->validate([
            'main_heading' => 'required|string',
            'sub_heading' => 'required|string',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        $content['main_heading'] = strip_tags($request->main_heading);
        $content['sub_heading'] = strip_tags($request->sub_heading);

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return redirect()->route('tata_usaha.content')->with('success', 'Teks utama landing page berhasil diperbarui.');
    }

    /**
     * Update countdown timer settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'countdown_target' => 'required',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        $content['countdown_target'] = $request->countdown_target;

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return redirect()->route('tata_usaha.content')->with('success', 'Countdown target pendaftaran berhasil diperbarui.');
    }

    /**
     * Update terms & conditions.
     */
    public function updateTerms(Request $request)
    {
        $request->validate([
            'terms_content' => 'required|string',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        $content['terms_content'] = $request->terms_content;

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return redirect()->route('tata_usaha.content')->with('success', 'Syarat pendaftaran berhasil diperbarui.');
    }

    /**
     * Upload digital booklet.
     */
    public function uploadBooklet(Request $request)
    {
        $request->validate([
            'booklet_file' => 'required|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('booklet_file')) {
            $file = $request->file('booklet_file');
            $filename = 'booklet_pmbm_2026.pdf'; // Keep static or track name
            $file->move(public_path('uploads/booklet'), $filename);
        }

        return redirect()->route('tata_usaha.content')->with('success', 'File booklet panduan berhasil diunggah.');
    }

    /**
     * Update dashboard background image.
     */
    public function updateBackground(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $filename = 'dashboard_bg.jpg';
            $path = public_path('uploads/background');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $filename);
        }

        return redirect()->route('tata_usaha.content')->with('success', 'Gambar background dashboard berhasil diperbarui.');
    }

    /**
     * Update school contact and location details.
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'address' => 'required|string|max:500',
            'instagram' => 'nullable|string|max:200',
            'facebook' => 'nullable|string|max:200',
            'youtube' => 'nullable|string|max:200',
            'gmaps_iframe' => 'nullable|string|max:2000',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        $content['phone'] = $request->phone;
        $content['email'] = $request->email;
        $content['address'] = $request->address;
        $content['instagram'] = $request->instagram;
        $content['facebook'] = $request->facebook;
        $content['youtube'] = $request->youtube;
        $content['gmaps_iframe'] = $request->gmaps_iframe;

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return redirect()->route('tata_usaha.content')->with('success', 'Kontak dan media sosial sekolah berhasil diperbarui.');
    }

    /**
     * Manage user accounts list.
     */
    public function accounts()
    {
        $accounts = [];

        foreach (PengurusTataUsaha::all() as $tu) {
            $accounts[] = [
                'id' => $tu->id_pengurus,
                'name' => $tu->nama_pengurus,
                'email' => $tu->email,
                'role' => 'tata_usaha',
                'role_label' => $tu->role === 'super admin' ? 'Super Admin' : 'Tata Usaha / Admin',
            ];
        }

        foreach (PanitiaPmbm::all() as $panitia) {
            $accounts[] = [
                'id' => $panitia->id_panitia,
                'name' => $panitia->nama_panitia,
                'email' => $panitia->email,
                'role' => 'panitia',
                'role_label' => 'Panitia Penguji',
            ];
        }

        return view('pengguna.index', compact('accounts'));
    }

    /**
     * Show form to create user account.
     */
    public function createAccount()
    {
        return view('pengguna.create');
    }

    /**
     * Show form to edit user account.
     */
    public function editAccountPage($role, $id)
    {
        if ($role === 'tata_usaha') {
            $account = PengurusTataUsaha::findOrFail($id);
            $accountData = [
                'id' => $account->id_pengurus,
                'name' => $account->nama_pengurus,
                'email' => $account->email,
                'role' => $account->role === 'super admin' ? 'super_admin' : 'tata_usaha',
                'role_label' => $account->role === 'super admin' ? 'Super Admin' : 'Tata Usaha / Admin',
            ];
        } else {
            $account = PanitiaPmbm::findOrFail($id);
            $accountData = [
                'id' => $account->id_panitia,
                'name' => $account->nama_panitia,
                'email' => $account->email,
                'role' => 'panitia',
                'role_label' => 'Panitia Penguji',
            ];
        }

        return view('pengguna.edit', compact('accountData', 'role', 'id'));
    }

    /**
     * Store new user account.
     */
    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
            'role' => 'required|in:tata_usaha,super_admin,panitia',
        ]);

        $role = $request->role;

        if ($role === 'tata_usaha' || $role === 'super_admin') {
            // Check unique email in both tables
            if (PengurusTataUsaha::where('email', $request->email)->exists() || PanitiaPmbm::where('email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email sudah terdaftar.']);
            }

            PengurusTataUsaha::create([
                'nama_pengurus' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_plain' => $request->password,
                'role' => $role === 'super_admin' ? 'super admin' : 'admin',
            ]);
        } else {
            // Check unique email in both tables
            if (PengurusTataUsaha::where('email', $request->email)->exists() || PanitiaPmbm::where('email', $request->email)->exists()) {
                return back()->withErrors(['email' => 'Email sudah terdaftar.']);
            }

            PanitiaPmbm::create([
                'nama_panitia' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_plain' => $request->password,
            ]);
        }

        return redirect()->route('tata_usaha.accounts')->with('success', 'Akun baru berhasil ditambahkan.');
    }

    /**
     * Update user account.
     */
    public function updateAccount(Request $request, $role, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:8',
            'role' => 'required|in:tata_usaha,super_admin,panitia',
        ]);

        $newRole = $request->role;
        $email = $request->email;

        // Email uniqueness validation ignoring current user
        if ($role === 'tata_usaha') {
            if (PengurusTataUsaha::where('email', $email)->where('id_pengurus', '!=', $id)->exists() || 
                PanitiaPmbm::where('email', $email)->exists()) {
                return back()->withErrors(['email' => 'Email sudah terdaftar pada pengguna lain.']);
            }
        } else {
            if (PanitiaPmbm::where('email', $email)->where('id_panitia', '!=', $id)->exists() || 
                PengurusTataUsaha::where('email', $email)->exists()) {
                return back()->withErrors(['email' => 'Email sudah terdaftar pada pengguna lain.']);
            }
        }

        // Prevent self-role-demotion
        if ($role === 'tata_usaha' && auth()->guard('tata_usaha')->id() == $id) {
            if ($newRole !== 'tata_usaha' && $newRole !== 'super_admin') {
                return back()->withErrors(['role' => 'Anda tidak dapat memindahkan akun Anda sendiri yang sedang aktif ke role Panitia.']);
            }
        }

        $isOriginalAdmin = ($role === 'tata_usaha');
        $isNewAdmin = ($newRole === 'tata_usaha' || $newRole === 'super_admin');

        if ($isOriginalAdmin) {
            $account = PengurusTataUsaha::findOrFail($id);

            // Verify not last super admin
            if ($account->role === 'super admin' && $newRole !== 'super_admin') {
                if (PengurusTataUsaha::where('role', 'super admin')->count() <= 1) {
                    return back()->withErrors(['role' => 'Tidak dapat mengubah role satu-satunya akun Super Admin.']);
                }
            }

            if ($isNewAdmin) {
                $account->nama_pengurus = $request->name;
                $account->email = $email;
                $account->role = ($newRole === 'super_admin' ? 'super admin' : 'admin');
                if ($request->filled('password')) {
                    $account->password = Hash::make($request->password);
                    $account->password_plain = $request->password;
                }
                $account->save();
            } else {
                $passwordHash = $account->password;
                $passwordPlain = $account->password_plain ?? 'Password123';
                if ($request->filled('password')) {
                    $passwordHash = Hash::make($request->password);
                    $passwordPlain = $request->password;
                }

                $account->delete();

                PanitiaPmbm::create([
                    'nama_panitia' => $request->name,
                    'email' => $email,
                    'password' => $passwordHash,
                    'password_plain' => $passwordPlain,
                ]);
            }
        } else {
            $account = PanitiaPmbm::findOrFail($id);

            if (!$isNewAdmin) {
                $account->nama_panitia = $request->name;
                $account->email = $email;
                if ($request->filled('password')) {
                    $account->password = Hash::make($request->password);
                    $account->password_plain = $request->password;
                }
                $account->save();
            } else {
                $passwordHash = $account->password;
                $passwordPlain = $account->password_plain ?? 'Password123';
                if ($request->filled('password')) {
                    $passwordHash = Hash::make($request->password);
                    $passwordPlain = $request->password;
                }

                $account->delete();

                PengurusTataUsaha::create([
                    'nama_pengurus' => $request->name,
                    'email' => $email,
                    'password' => $passwordHash,
                    'password_plain' => $passwordPlain,
                    'role' => ($newRole === 'super_admin' ? 'super admin' : 'admin'),
                ]);
            }
        }

        return redirect()->route('tata_usaha.accounts')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Delete user account.
     */
    public function deleteAccount($role, $id)
    {
        if ($role === 'tata_usaha') {
            $user = PengurusTataUsaha::findOrFail($id);
            // Protect current logged-in user from self-deletion
            if (auth()->guard('tata_usaha')->id() == $id) {
                return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri yang sedang digunakan.']);
            }
            $user->delete();
        } elseif ($role === 'panitia') {
            $user = PanitiaPmbm::findOrFail($id);
            $user->delete();
        }

        return redirect()->route('tata_usaha.accounts')->with('success', 'Akun berhasil dihapus.');
    }

    /**
     * Store a new program.
     */
    public function storeProgram(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'persyaratan' => 'required|string',
            'kuota_program' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'weight_hafalan' => 'required|integer|min:0|max:100',
            'weight_wawancara' => 'required|integer|min:0|max:100',
            'weight_calistung' => 'required|integer|min:0|max:100',
            'weight_tasmi' => 'required|integer|min:0|max:100',
            'weight_mandiri' => 'required|integer|min:0|max:100',
        ]);

        $wHafalan = (int) $request->weight_hafalan;
        $wWawancara = (int) $request->weight_wawancara;
        $wCalistung = (int) $request->weight_calistung;
        $wTasmi = (int) $request->weight_tasmi;
        $wMandiri = (int) $request->weight_mandiri;

        $totalWeight = $wHafalan + $wWawancara + $wCalistung + $wTasmi + $wMandiri;
        if ($totalWeight !== 100) {
            return back()->with('error', "Total bobot nilai harus sama dengan 100%! (Total saat ini: {$totalWeight}%)")->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_program_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/programs'), $filename);
            $imagePath = '/uploads/programs/' . $filename;
        }

        Program::create([
            'nama_program' => $request->nama_program,
            'persyaratan' => $request->persyaratan,
            'kuota_program' => $request->kuota_program,
            'image' => $imagePath,
            'dss_weights' => [
                'hafalan' => $wHafalan,
                'wawancara' => $wWawancara,
                'calistung' => $wCalistung,
                'tasmi' => $wTasmi,
                'mandiri' => $wMandiri,
            ]
        ]);

        // Dynamic DSS recommendation update
        \App\Services\DssService::recalculateAll();

        return redirect()->route('tata_usaha.content')->with('success', 'Program pendidikan baru berhasil ditambahkan.');
    }

    /**
     * Update an existing program.
     */
    public function updateProgram(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'persyaratan' => 'required|string',
            'kuota_program' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'weight_hafalan' => 'required|integer|min:0|max:100',
            'weight_wawancara' => 'required|integer|min:0|max:100',
            'weight_calistung' => 'required|integer|min:0|max:100',
            'weight_tasmi' => 'required|integer|min:0|max:100',
            'weight_mandiri' => 'required|integer|min:0|max:100',
        ]);

        $wHafalan = (int) $request->weight_hafalan;
        $wWawancara = (int) $request->weight_wawancara;
        $wCalistung = (int) $request->weight_calistung;
        $wTasmi = (int) $request->weight_tasmi;
        $wMandiri = (int) $request->weight_mandiri;

        $totalWeight = $wHafalan + $wWawancara + $wCalistung + $wTasmi + $wMandiri;
        if ($totalWeight !== 100) {
            return back()->with('error', "Total bobot nilai harus sama dengan 100%! (Total saat ini: {$totalWeight}%)")->withInput();
        }

        $program = Program::findOrFail($id);

        $imagePath = $program->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($program->image && file_exists(public_path($program->image))) {
                @unlink(public_path($program->image));
            }
            
            $file = $request->file('image');
            $filename = time() . '_program_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/programs'), $filename);
            $imagePath = '/uploads/programs/' . $filename;
        }

        $program->update([
            'nama_program' => $request->nama_program,
            'persyaratan' => $request->persyaratan,
            'kuota_program' => $request->kuota_program,
            'image' => $imagePath,
            'dss_weights' => [
                'hafalan' => $wHafalan,
                'wawancara' => $wWawancara,
                'calistung' => $wCalistung,
                'tasmi' => $wTasmi,
                'mandiri' => $wMandiri,
            ]
        ]);

        // Dynamic DSS recommendation update
        \App\Services\DssService::recalculateAll();

        return redirect()->route('tata_usaha.content')->with('success', 'Program pendidikan berhasil diperbarui.');
    }

    /**
     * Delete a program.
     */
    public function deleteProgram($id)
    {
        $program = Program::findOrFail($id);

        // Delete image file from disk
        if ($program->image && file_exists(public_path($program->image))) {
            @unlink(public_path($program->image));
        }

        $program->delete();

        // Dynamic DSS recommendation update
        \App\Services\DssService::recalculateAll();

        return redirect()->route('tata_usaha.content')->with('success', 'Program pendidikan berhasil dihapus.');
    }

    /**
     * Update DSS configuration weights and predicates.
     */
    public function updateDssConfig(Request $request)
    {
        $request->validate([
            // Predikats
            'pred_sangat_cakap_min' => 'required|integer|min:0|max:100',
            'pred_sangat_cakap_max' => 'required|integer|min:0|max:100',
            'pred_cakap_min' => 'required|integer|min:0|max:100',
            'pred_cakap_max' => 'required|integer|min:0|max:100',
            'pred_cukup_cakap_min' => 'required|integer|min:0|max:100',
            'pred_cukup_cakap_max' => 'required|integer|min:0|max:100',
            'pred_perhatian_min' => 'required|integer|min:0|max:100',
            'pred_perhatian_max' => 'required|integer|min:0|max:100',
        ]);

        // Store in DB
        $setting = \App\Models\PmbmSetting::first();
        if (!$setting) {
            $setting = new \App\Models\PmbmSetting();
            $setting->registration_open = true;
            $setting->current_angkatan = date('Y');
        }

        // Keep existing weights, just update predikats
        $currentWeights = isset($setting->dss_weights['weights']) ? $setting->dss_weights['weights'] : [
            'hafalan' => 30,
            'wawancara' => 20,
            'calistung' => 20,
            'tasmi' => 15,
            'mandiri' => 15
        ];

        $setting->dss_weights = [
            'weights' => $currentWeights,
            'predikats' => [
                [
                    'min' => (int) $request->pred_sangat_cakap_min,
                    'max' => (int) $request->pred_sangat_cakap_max,
                    'label' => 'Sangat Cakap',
                ],
                [
                    'min' => (int) $request->pred_cakap_min,
                    'max' => (int) $request->pred_cakap_max,
                    'label' => 'Cakap',
                ],
                [
                    'min' => (int) $request->pred_cukup_cakap_min,
                    'max' => (int) $request->pred_cukup_cakap_max,
                    'label' => 'Cukup Cakap',
                ],
                [
                    'min' => (int) $request->pred_perhatian_min,
                    'max' => (int) $request->pred_perhatian_max,
                    'label' => 'Butuh Perhatian',
                ],
            ]
        ];
        
        $setting->save();

        // Trigger mass recalculation
        \App\Services\DssService::recalculateAll();

        return redirect()->route('tata_usaha.content')->with('success', 'Konfigurasi predikat batas angka DSS berhasil diperbarui!');
    }

    /**
     * Store new rundown item in json.
     */
    public function storeRundown(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        if (!isset($content['rundown']) || !is_array($content['rundown'])) {
            $content['rundown'] = [];
        }

        $content['rundown'][] = [
            'kegiatan' => $request->kegiatan,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ];

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return redirect()->route('tata_usaha.content')->with('success', 'Item rundown kegiatan berhasil ditambahkan.');
    }
    
    /**
     * Update rundown item in json.
     */
    public function updateRundown(Request $request, $index)
    {
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
            if (isset($content['rundown'][$index])) {
                $content['rundown'][$index] = [
                    'kegiatan' => $request->kegiatan,
                    'tanggal' => $request->tanggal,
                    'keterangan' => $request->keterangan,
                ];
                file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));
            }
        }

        return redirect()->route('tata_usaha.content')->with('success', 'Item rundown kegiatan berhasil diperbarui.');
    }

    /**
     * Delete rundown item from json.
     */
    public function deleteRundown(Request $request, $index)
    {
        $contentPath = storage_path('app/landing_content.json');
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
            if (isset($content['rundown'][$index])) {
                array_splice($content['rundown'], $index, 1);
                file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));
            }
        }

        return redirect()->route('tata_usaha.content')->with('success', 'Item rundown kegiatan berhasil dihapus.');
    }


    /**
     * Auto expire waitlisted (Cadangan) candidates after 1 week.
     */
    private function autoExpireWaitlists()
    {
        Pendaftaran::where('status', 'Cadangan')
            ->where('updated_at', '<', now()->subWeek())
            ->update(['status' => 'Tidak Lulus']);
    }
}
