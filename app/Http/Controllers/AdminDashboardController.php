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
    public function index(Request $request)
    {
        $this->autoExpireWaitlists();

        $programs = Program::all();

        $query = Pendaftaran::query();
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pendaftaran', $request->tahun);
        }
        if ($request->filled('program')) {
            $query->where('id_program', $request->program);
        }

        $totalPeserta = (clone $query)->count();
        $totalTidakKeterima = (clone $query)->where(function ($q) {
                $q->where('status_kelulusan', 'tidak_lulus')
                  ->orWhere('status_verifikasi', 'ditolak')
                  ->orWhere('status_konfirmasi', 'mengundurkan_diri');
            })->count();
        $totalKeterima = (clone $query)->where('status_kelulusan', 'lulus')->count();
        $tingkatKelulusan = ($totalPeserta > 0) ? round(($totalKeterima / $totalPeserta) * 100) : 0;

        $programKelasDibuka = Program::count();
        $totalTidakKonfirmasi = (clone $query)
            ->where('status_kelulusan', 'lulus')
            ->where(function ($q) {
                $q->whereNull('status_konfirmasi')
                  ->orWhere('status_konfirmasi', 'belum_konfirmasi');
            })->count();

        // Group chart counts by year dynamically
        $years = [now()->year - 2, now()->year - 1, now()->year];
        $charts = [
            'pendaftar' => [],
            'keterima' => []
        ];

        foreach ($years as $year) {
            $charts['pendaftar'][$year] = Pendaftaran::whereYear('tanggal_pendaftaran', $year)->count();
            $charts['keterima'][$year] = Pendaftaran::whereYear('tanggal_pendaftaran', $year)
                ->where('status_kelulusan', 'lulus')
                ->count();
        }

        $recentApplicants = (clone $query)->with(['calonMurid', 'program'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalPeserta', 'totalTidakKeterima', 'totalKeterima', 'tingkatKelulusan',
            'charts', 'programs', 'programKelasDibuka', 'totalTidakKonfirmasi', 'recentApplicants'
        ));
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
            $status = $request->status;
            if (in_array($status, ['menunggu_verifikasi', 'ditolak', 'terverifikasi', 'terverifikasi_onsite'])) {
                $query->where('status_verifikasi', $status);
            } elseif (in_array($status, ['lulus', 'tidak_lulus', 'cadangan'])) {
                $query->where('status_kelulusan', $status);
            } elseif (in_array($status, ['belum_konfirmasi', 'terkonfirmasi', 'mengundurkan_diri'])) {
                $query->where('status_konfirmasi', $status);
            }
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
        $pendaftaran = Pendaftaran::findOrFail($id);
        $action = $request->input('action');
        
        switch ($action) {
            case 'verifikasi_berkas':
                $request->validate([
                    'status_verifikasi' => 'required|string|in:terverifikasi,ditolak',
                    'alasan_penolakan' => 'required_if:status_verifikasi,ditolak|nullable|string|max:1000'
                ]);
                $pendaftaran->status_verifikasi = $request->status_verifikasi;
                if ($request->status_verifikasi === 'ditolak') {
                    $pendaftaran->alasan_penolakan = $request->alasan_penolakan;
                } else {
                    $pendaftaran->alasan_penolakan = null;
                    $pendaftaran->tanggal_verifikasi = now();
                }
                break;
                
            case 'cek_berkas_onsite':
                $pendaftaran->status_verifikasi = 'terverifikasi_onsite';
                break;
                
            case 'penetapan_kelulusan':
                $request->validate([
                    'status_kelulusan' => 'required|string|in:lulus,tidak_lulus,cadangan'
                ]);
                $pendaftaran->status_kelulusan = $request->status_kelulusan;
                $pendaftaran->tanggal_kelulusan = now();
                if ($request->status_kelulusan === 'lulus') {
                    $pendaftaran->status_konfirmasi = 'belum_konfirmasi';
                } else {
                    $pendaftaran->status_konfirmasi = null;
                }
                break;
                
            case 'konfirmasi_onsite':
                $request->validate([
                    'status_konfirmasi' => 'required|string|in:terkonfirmasi,mengundurkan_diri'
                ]);
                $pendaftaran->status_konfirmasi = $request->status_konfirmasi;
                $pendaftaran->tanggal_konfirmasi = now();
                break;
                
            case 'promosi_cadangan':
                $pendaftaran->status_kelulusan = 'lulus';
                $pendaftaran->status_konfirmasi = 'belum_konfirmasi';
                $pendaftaran->peringkat_cadangan = null;
                $pendaftaran->tanggal_kelulusan = now();
                break;
                
            default:
                return back()->with('error', 'Aksi pembaruan status tidak dikenal.');
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
        
        // Fetch FAQs and School Contacts for CRUD management tabs
        $faqs = \App\Models\Faq::orderBy('created_at', 'desc')->get();
        $contacts = \App\Models\SchoolContact::all();
 
        return view('master.landing', compact('content', 'settings', 'programs', 'dssConfig', 'faqs', 'contacts'));
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
    public function updateGeneralContact(Request $request)
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
        if (auth()->guard('tata_usaha')->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola akun.');
        }

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
        if (auth()->guard('tata_usaha')->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola akun.');
        }

        return view('pengguna.create');
    }

    /**
     * Show form to edit user account.
     */
    public function editAccountPage($role, $id)
    {
        if (auth()->guard('tata_usaha')->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola akun.');
        }

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
        if (auth()->guard('tata_usaha')->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola akun.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
            'role' => 'required|in:tata_usaha,panitia',
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
        if (auth()->guard('tata_usaha')->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola akun.');
        }

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
        if (auth()->guard('tata_usaha')->user()->role !== 'super admin') {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola akun.');
        }

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
            'pred_sangat_cakap_min' => 'required|integer|min:0|max:10',
            'pred_sangat_cakap_max' => 'required|integer|min:0|max:10',
            'pred_cakap_min' => 'required|integer|min:0|max:10',
            'pred_cakap_max' => 'required|integer|min:0|max:10',
            'pred_cukup_cakap_min' => 'required|integer|min:0|max:10',
            'pred_cukup_cakap_max' => 'required|integer|min:0|max:10',
            'pred_perhatian_min' => 'required|integer|min:0|max:10',
            'pred_perhatian_max' => 'required|integer|min:0|max:10',
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
     * Auto expire waitlisted (Cadangan) candidates and unconfirmed Lulus candidates.
     */
    private function autoExpireWaitlists()
    {
        // Lulus candidates who do not confirm in 1 week automatically expire to 'mengundurkan_diri'
        Pendaftaran::where('status_kelulusan', 'lulus')
            ->where(function($q) {
                $q->whereNull('status_konfirmasi')
                  ->orWhere('status_konfirmasi', 'belum_konfirmasi');
            })
            ->where('tanggal_kelulusan', '<', now()->subWeek())
            ->update(['status_konfirmasi' => 'mengundurkan_diri']);
 
        // Cadangan candidates who are not promoted automatically expire to 'tidak_lulus'
        Pendaftaran::where('status_kelulusan', 'cadangan')
            ->where('updated_at', '<', now()->subWeek())
            ->update(['status_kelulusan' => 'tidak_lulus']);
    }
 
    /**
     * Store a new FAQ.
     */
    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
 
        \App\Models\Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
 
        return redirect()->route('tata_usaha.content')->with('success_faq', 'FAQ baru berhasil ditambahkan.');
    }
 
    /**
     * Update an FAQ.
     */
    public function updateFaq(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);
 
        $faq = \App\Models\Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
 
        return redirect()->route('tata_usaha.content')->with('success_faq', 'FAQ berhasil diperbarui.');
    }
 
    /**
     * Delete an FAQ.
     */
    public function deleteFaq($id)
    {
        $faq = \App\Models\Faq::findOrFail($id);
        $faq->delete();
 
        return redirect()->route('tata_usaha.content')->with('success_faq', 'FAQ berhasil dihapus.');
    }
 
    /**
     * Store a new School Contact.
     */
    public function storeContact(Request $request)
    {
        $request->validate([
            'platform_name' => 'required|string',
            'value' => 'required|string',
            'link' => 'required|string',
            'icon' => 'nullable|string',
        ]);
 
        \App\Models\SchoolContact::create([
            'platform_name' => $request->platform_name,
            'value' => $request->value,
            'link' => $request->link,
            'icon' => $request->icon,
        ]);
 
        return redirect()->route('tata_usaha.content')->with('success_contact', 'Kontak/Media Sosial baru berhasil ditambahkan.');
    }
 
    /**
     * Update a School Contact.
     */
    public function updateContact(Request $request, $id)
    {
        $request->validate([
            'platform_name' => 'required|string',
            'value' => 'required|string',
            'link' => 'required|string',
            'icon' => 'nullable|string',
        ]);
 
        $contact = \App\Models\SchoolContact::findOrFail($id);
        $contact->update([
            'platform_name' => $request->platform_name,
            'value' => $request->value,
            'link' => $request->link,
            'icon' => $request->icon,
        ]);
 
        return redirect()->route('tata_usaha.content')->with('success_contact', 'Kontak/Media Sosial berhasil diperbarui.');
    }
 
    /**
     * Delete a School Contact.
     */
    public function deleteContact($id)
    {
        $contact = \App\Models\SchoolContact::findOrFail($id);
        $contact->delete();
 
        return redirect()->route('tata_usaha.content')->with('success_contact', 'Kontak/Media Sosial berhasil dihapus.');
    }

    /**
     * Change program study for applicant.
     */
    public function changeProgram(Request $request, $id)
    {
        $request->validate([
            'id_program' => 'required|exists:programs,id_program',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->id_program = $request->id_program;
        $pendaftaran->save();

        $student = $pendaftaran->calonMurid;
        if ($student && $student->hasil) {
            $student->hasil->id_program = $request->id_program;
            $student->hasil->save();
        }

        // Trigger recalculation of rankings/DSS
        \App\Services\DssService::recalculateAll();

        return back()->with('success', 'Program kelas pilihan calon murid berhasil diubah dan sistem DSS telah disesuaikan.');
    }
}
