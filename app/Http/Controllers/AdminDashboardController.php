<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Program;
use App\Models\CalonMurid;
use App\Models\PengurusTataUsaha;
use App\Models\PanitiaPmbm;
use App\Models\PeriodePendaftaran;
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

        $activePeriod = PeriodePendaftaran::where('status', 'aktif')->first();
        $programs = $this->getActivePrograms($activePeriod);

        $query = Pendaftaran::query();

        // Filter berdasarkan periode aktif
        if ($activePeriod) {
            $query->where('periode_pendaftaran_id', $activePeriod->id);
        } else {
            $query->whereRaw('1 = 0'); // Tidak ada periode aktif = data kosong
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

        // Recent Applicants Query with Search & Filters
        $recentQuery = (clone $query)->with(['calonMurid', 'program']);

        if ($request->filled('search')) {
            $search = $request->search;
            $recentQuery->whereHas('calonMurid', function ($q) use ($search) {
                $q->where('nama_murid', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if (in_array($status, ['menunggu_verifikasi', 'ditolak', 'terverifikasi', 'terverifikasi_onsite'])) {
                $recentQuery->where('status_verifikasi', $status);
            } elseif (in_array($status, ['lulus', 'tidak_lulus', 'cadangan'])) {
                $recentQuery->where('status_kelulusan', $status);
            } elseif (in_array($status, ['belum_konfirmasi', 'terkonfirmasi', 'mengundurkan_diri'])) {
                $recentQuery->where('status_konfirmasi', $status);
            }
        }

        if ($request->filled('program_kelulusan')) {
            $recentQuery->where('program_kelulusan', $request->program_kelulusan);
        }

        $recentApplicants = $recentQuery
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalPeserta', 'totalTidakKeterima', 'totalKeterima', 'tingkatKelulusan',
            'charts', 'programs', 'programKelasDibuka', 'totalTidakKonfirmasi', 'recentApplicants', 'activePeriod'
        ));
    }
 
    /**
     * List applicants with filters.
     */
    public function applicants(Request $request)
    {
        $this->autoExpireWaitlists();
        $activePeriod = $this->resolvePeriod($request);
        $programs = $this->getActivePrograms($activePeriod);
        
        $query = Pendaftaran::with(['calonMurid.ayah', 'calonMurid.ibu', 'program'])
            ->join('calon_murids', 'pendaftarans.id_murid', '=', 'calon_murids.id_murid')
            ->select('pendaftarans.*');

        // Filter berdasarkan periode aktif
        if ($activePeriod) {
            $query->where('pendaftarans.periode_pendaftaran_id', $activePeriod->id);
        } else {
            $query->whereRaw('1 = 0');
        }

        // Search filter (name, nisn, or parent name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('calon_murids.nama_murid', 'like', "%{$search}%")
                  ->orWhere('calon_murids.nisn', 'like', "%{$search}%")
                  ->orWhereHas('calonMurid.ayah', function ($qa) use ($search) {
                      $qa->where('nama_ayah', 'like', "%{$search}%");
                  })
                  ->orWhereHas('calonMurid.ibu', function ($qi) use ($search) {
                      $qi->where('nama_ibu', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'belum_konfirmasi') {
                $query->where(function($q) {
                    $q->where('pendaftarans.status_verifikasi', 'menunggu_verifikasi')
                      ->orWhere('pendaftarans.status_konfirmasi', 'belum_konfirmasi');
                });
            } elseif ($status === 'terkonfirmasi') {
                $query->where(function($q) {
                    $q->where('pendaftarans.status_verifikasi', 'terverifikasi')
                      ->orWhere('pendaftarans.status_konfirmasi', 'terkonfirmasi');
                });
            } elseif (in_array($status, ['menunggu_verifikasi', 'ditolak', 'terverifikasi', 'terverifikasi_onsite'])) {
                $query->where('pendaftarans.status_verifikasi', $status);
            } elseif (in_array($status, ['lulus', 'tidak_lulus', 'cadangan'])) {
                $query->where('pendaftarans.status_kelulusan', $status);
            } elseif (in_array($status, ['mengundurkan_diri'])) {
                $query->where('pendaftarans.status_konfirmasi', $status);
            }
        }

        // Filter by Program Study
        if ($request->filled('program')) {
            $query->where('pendaftarans.id_program', $request->program);
        }

        // Sorting
        $sort = $request->input('sort', 'date_desc');
        if ($sort === 'name_asc') {
            $query->orderBy('calon_murids.nama_murid', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('calon_murids.nama_murid', 'desc');
        } elseif ($sort === 'date_asc') {
            $query->orderBy('pendaftarans.tanggal_pendaftaran', 'asc');
        } else {
            $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc');
        }

        // Limit results
        $limit = $request->integer('limit', 10);
        if ($limit > 0) {
            $pendaftarans = $query->take($limit)->get();
        } else {
            $pendaftarans = $query->get();
        }

        return view('pendaftaran.index', compact('pendaftarans', 'programs', 'limit', 'activePeriod', 'sort'));
    }

    /**
     * List applicants filtered by Grup WhatsApp status.
     */
    public function grupWhatsapp(Request $request)
    {
        $this->autoExpireWaitlists();
        $activePeriod = $this->resolvePeriod($request);
        $programs = $this->getActivePrograms($activePeriod);

        $query = Pendaftaran::with(['calonMurid.ibu', 'program']);

        // Filter berdasarkan periode aktif
        if ($activePeriod) {
            $query->where('periode_pendaftaran_id', $activePeriod->id);
        } else {
            $query->whereRaw('1 = 0');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('calonMurid', function ($q) use ($search) {
                $q->where('nama_murid', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_grup_wa', $request->status);
        }

        if ($request->filled('program')) {
            $query->where('id_program', $request->program);
        }

        $limit = $request->integer('limit', 10);
        if ($limit > 0) {
            $pendaftarans = $query->orderBy('created_at', 'desc')->take($limit)->get();
        } else {
            $pendaftarans = $query->orderBy('created_at', 'desc')->get();
        }

        return view('pendaftaran.grup-whatsapp', compact('pendaftarans', 'programs', 'activePeriod', 'limit'));
    }

    /**
     * Toggle Grup WhatsApp status for an applicant.
     */
    public function updateGrupWhatsapp(Request $request, $id)
    {
        $request->validate([
            'status_grup_wa' => 'required|in:belum_masuk,sudah_masuk',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->status_grup_wa = $request->status_grup_wa;
        $pendaftaran->save();

        return back()->with('success', 'Status Grup WhatsApp berhasil diperbarui.');
    }

    /**
     * View specific applicant profile.
     */
    public function detail($id)
    {
        $this->autoExpireWaitlists();
        
        // Auto-clear view cache to resolve any compiled Blade conflicts
        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch (\Exception $e) {
            // Ignore if fails
        }

        $pendaftaran = Pendaftaran::with(['calonMurid.ayah', 'calonMurid.ibu', 'program', 'nilaiUjian', 'wawancaraAnak', 'wawancaraOrtu', 'dssRanking'])
            ->findOrFail($id);
        
        $student = $pendaftaran->calonMurid;

        return view('profile.show', compact('pendaftaran', 'student'));
    }

    /**
     * List applicants for Offline Verification phase.
     */
    public function verifikasiOffline(Request $request)
    {
        $activePeriod = $this->resolvePeriod($request);
        $programs = $this->getActivePrograms($activePeriod);

        $query = Pendaftaran::with(['calonMurid.ayah', 'calonMurid.ibu', 'program'])
            ->join('calon_murids', 'pendaftarans.id_murid', '=', 'calon_murids.id_murid')
            ->select('pendaftarans.*');

        if ($activePeriod) {
            $query->where('pendaftarans.periode_pendaftaran_id', $activePeriod->id);
        } else {
            $query->whereRaw('1 = 0');
        }

        // Show students who are in offline verification stage
        if ($request->filled('status')) {
            $query->where('pendaftarans.status_verifikasi', $request->status);
        } else {
            $query->whereIn('pendaftarans.status_verifikasi', ['terverifikasi', 'terverifikasi_onsite']);
        }

        // Apply search if present
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('calon_murids.nama_murid', 'like', "%{$search}%")
                  ->orWhere('calon_murids.nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program')) {
            $query->where('pendaftarans.id_program', $request->program);
        }

        $limit = $request->integer('limit', 10);
        if ($limit > 0) {
            $pendaftarans = $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc')->take($limit)->get();
        } else {
            $pendaftarans = $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc')->get();
        }

        return view('pendaftaran.verifikasi-offline', compact('pendaftarans', 'programs', 'activePeriod', 'limit'));
    }

    /**
     * List applicants for Selection phase with Ujian/Wawancara marks & DSS Recommendations.
     */
    public function seleksi(Request $request)
    {
        // Recalculate rankings and DSS recommendations
        \App\Services\DssService::recalculateAll();

        $activePeriod = $this->resolvePeriod($request);
        $programs = $this->getActivePrograms($activePeriod);

        $query = Pendaftaran::with(['calonMurid.ayah', 'calonMurid.ibu', 'program', 'nilaiUjian', 'dssRanking'])
            ->join('calon_murids', 'pendaftarans.id_murid', '=', 'calon_murids.id_murid')
            ->select('pendaftarans.*');

        if ($activePeriod) {
            $query->where('pendaftarans.periode_pendaftaran_id', $activePeriod->id);
        } else {
            $query->whereRaw('1 = 0');
        }

        // Show students who are verified and ready for selection
        $query->whereIn('pendaftarans.status_verifikasi', ['terverifikasi', 'terverifikasi_onsite']);

        // Apply search if present
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('calon_murids.nama_murid', 'like', "%{$search}%")
                  ->orWhere('calon_murids.nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program')) {
            $query->where('pendaftarans.id_program', $request->program);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'belum_ditetapkan') {
                $query->whereNull('pendaftarans.status_kelulusan');
            } elseif (in_array($status, ['lulus', 'cadangan', 'tidak_lulus'])) {
                $query->where('pendaftarans.status_kelulusan', $status);
            }
        }

        $limit = $request->integer('limit', 10);
        if ($limit > 0) {
            $pendaftarans = $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc')->take($limit)->get();
        } else {
            $pendaftarans = $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc')->get();
        }

        return view('pendaftaran.seleksi', compact('pendaftarans', 'programs', 'activePeriod', 'limit'));
    }

    /**
     * List applicants for Re-registration (Daftar Ulang) phase.
     */
    public function daftarUlang(Request $request)
    {
        $activePeriod = $this->resolvePeriod($request);
        $programs = $this->getActivePrograms($activePeriod);

        $query = Pendaftaran::with(['calonMurid.ayah', 'calonMurid.ibu', 'program'])
            ->join('calon_murids', 'pendaftarans.id_murid', '=', 'calon_murids.id_murid')
            ->select('pendaftarans.*');

        if ($activePeriod) {
            $query->where('pendaftarans.periode_pendaftaran_id', $activePeriod->id);
        } else {
            $query->whereRaw('1 = 0');
        }

        // Only show candidates who are graduated (Lulus)
        $query->where('pendaftarans.status_kelulusan', 'lulus');

        // Apply search if present
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('calon_murids.nama_murid', 'like', "%{$search}%")
                  ->orWhere('calon_murids.nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program')) {
            $query->where('pendaftarans.id_program', $request->program);
        }

        if ($request->filled('status')) {
            $query->where('pendaftarans.status_konfirmasi', $request->status);
        }

        $limit = $request->integer('limit', 10);
        if ($limit > 0) {
            $pendaftarans = $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc')->take($limit)->get();
        } else {
            $pendaftarans = $query->orderBy('pendaftarans.tanggal_pendaftaran', 'desc')->get();
        }

        return view('pendaftaran.daftar-ulang', compact('pendaftarans', 'programs', 'activePeriod', 'limit'));
    }

    /**
     * Change target program or graduation program.
     */
    public function changeProgram(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $request->validate([
            'id_program' => 'required|exists:programs,id_program',
            'type' => 'nullable|string|in:pilihan,kelulusan'
        ]);

        if ($request->input('type') === 'kelulusan') {
            $prog = Program::find($request->id_program);
            $pendaftaran->program_kelulusan = $prog->nama_program;
        } else {
            $pendaftaran->id_program = $request->id_program;
            $student = $pendaftaran->calonMurid;
            if ($student && $student->hasil) {
                $student->hasil->id_program = $request->id_program;
                $student->hasil->save();
            }
        }

        $pendaftaran->save();

        // Trigger recalculation of rankings/DSS
        \App\Services\DssService::recalculateAll();

        return back()->with('success', 'Program pendaftaran berhasil diperbarui dan sistem DSS telah disesuaikan.');
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
                $request->validate([
                    'token_offline' => 'nullable|string|max:20',
                ]);
                $pendaftaran->token_offline = $request->token_offline ?? 'VERIFIED';
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
                    'status_konfirmasi' => 'required|string|in:terkonfirmasi,mengundurkan_diri,belum_konfirmasi'
                ]);
                $pendaftaran->status_konfirmasi = $request->status_konfirmasi;
                $pendaftaran->tanggal_konfirmasi = $request->status_konfirmasi === 'belum_konfirmasi' ? null : now();
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
        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
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
 
        $programs = Program::with('criteria')->get();
        $settings = $content; // map settings to the same content payload
        
        return view('master.landing', compact('content', 'settings', 'programs'));
    }

    /**
     * Show school contacts CRUD page.
     */
    public function showContacts()
    {
        $contacts = \App\Models\SchoolContact::all();

        // Load WhatsApp group link from landing content
        $contentPath = storage_path('app/landing_content.json');
        $landingContent = [];
        if (file_exists($contentPath)) {
            $landingContent = json_decode(file_get_contents($contentPath), true) ?? [];
        }
        $whatsappGroupLink = $landingContent['whatsapp_group_link'] ?? '';
        $whatsappGroupLulusLink = $landingContent['whatsapp_group_lulus_link'] ?? '';
        $whatsappGroupDiterimaLink = $landingContent['whatsapp_group_diterima_link'] ?? '';

        return view('master.contacts', compact('contacts', 'whatsappGroupLink', 'whatsappGroupLulusLink', 'whatsappGroupDiterimaLink'));
    }

    /**
     * Show FAQ CRUD page.
     */
    public function showFaqs()
    {
        $faqs = \App\Models\Faq::orderBy('created_at', 'desc')->get();
        return view('master.faqs', compact('faqs'));
    }

    /**
     * Show DSS parameter weights & predicates page.
     */
    public function showDssConfig()
    {
        $dssConfig = \App\Services\DssService::getConfig();
        return view('master.dss', compact('dssConfig'));
    }

    /**
     * Show internal tutorial videos page.
     */
    public function showTutorial()
    {
        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }
        return view('master.tutorial', compact('content'));
    }

    /**
     * Update landing page texts.
     */
    public function updateContentText(Request $request)
    {
        $request->validate([
            'main_heading' => 'nullable|string',
            'sub_heading' => 'nullable|string',
            'whatsapp_group_link' => 'nullable|url',
            'whatsapp_group_lulus_link' => 'nullable|url',
            'whatsapp_group_diterima_link' => 'nullable|url',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true) ?? [];
        }

        if ($request->filled('main_heading')) {
            $content['main_heading'] = strip_tags($request->main_heading);
        }
        if ($request->filled('sub_heading')) {
            $content['sub_heading'] = strip_tags($request->sub_heading);
        }
        if ($request->has('whatsapp_group_link')) {
            $content['whatsapp_group_link'] = strip_tags($request->whatsapp_group_link);
        }
        if ($request->has('whatsapp_group_lulus_link')) {
            $content['whatsapp_group_lulus_link'] = strip_tags($request->whatsapp_group_lulus_link);
        }
        if ($request->has('whatsapp_group_diterima_link')) {
            $content['whatsapp_group_diterima_link'] = strip_tags($request->whatsapp_group_diterima_link);
        }

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return back()->with('success', 'Data berhasil diperbarui.');
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
            'terms_general' => 'required|string',
            'terms_documents' => 'required|string',
            'terms_optional' => 'required|string',
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true);
        }

        $content['terms_general'] = $request->terms_general;
        $content['terms_documents'] = $request->terms_documents;
        $content['terms_optional'] = $request->terms_optional;

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
                'is_super_admin' => ($tu->role === 'super admin'),
            ];
        }

        foreach (PanitiaPmbm::all() as $panitia) {
            $accounts[] = [
                'id' => $panitia->id_panitia,
                'name' => $panitia->nama_panitia,
                'email' => $panitia->email,
                'role' => 'panitia',
                'role_label' => $panitia->role_panitia === 'petugas_wawancara' ? 'Panitia Wawancara' : 'Panitia Pengawas Ujian',
                'is_super_admin' => false,
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
                'role' => $account->role_panitia === 'petugas_wawancara' ? 'panitia_wawancara' : 'panitia_ujian',
                'role_label' => $account->role_panitia === 'petugas_wawancara' ? 'Panitia Wawancara' : 'Panitia Pengawas Ujian',
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
            'role' => 'required|in:tata_usaha,panitia_ujian,panitia_wawancara',
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
                'role_panitia' => $role === 'panitia_ujian' ? 'pengawas_ujian' : 'petugas_wawancara',
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
            'role' => 'required|in:tata_usaha,super_admin,panitia_ujian,panitia_wawancara',
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
                    'role_panitia' => $newRole === 'panitia_ujian' ? 'pengawas_ujian' : 'petugas_wawancara',
                ]);
            }
        } else {
            $account = PanitiaPmbm::findOrFail($id);

            if (!$isNewAdmin) {
                $account->nama_panitia = $request->name;
                $account->email = $email;
                $account->role_panitia = $newRole === 'panitia_ujian' ? 'pengawas_ujian' : 'petugas_wawancara';
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
            if ($user->role === 'super admin') {
                return back()->with('error', 'Akun Super Admin tidak dapat dihapus.');
            }
            if (auth()->guard('tata_usaha')->id() == $id) {
                return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri yang sedang digunakan.');
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
            'criteria_name' => 'nullable|array',
            'criteria_name.*' => 'required|string|in:hafalan,aism,iqro,calistung,dikte,kemandirian',
            'criteria_min' => 'nullable|array',
            'criteria_min.*' => 'required|integer|min:0|max:100',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_program_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/programs'), $filename);
            $imagePath = '/uploads/programs/' . $filename;
        }

        $program = Program::create([
            'nama_program' => $request->nama_program,
            'persyaratan' => $request->persyaratan,
            'kuota_program' => $request->kuota_program,
            'image' => $imagePath,
        ]);

        if ($request->has('criteria_name') && is_array($request->criteria_name)) {
            foreach ($request->criteria_name as $idx => $name) {
                $minVal = isset($request->criteria_min[$idx]) ? (int)$request->criteria_min[$idx] : 0;
                $program->criteria()->create([
                    'nama_kriteria' => $name,
                    'nilai_minimum' => $minVal,
                ]);
            }
        }

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
            'criteria_name' => 'nullable|array',
            'criteria_name.*' => 'required|string|in:hafalan,aism,iqro,calistung,dikte,kemandirian',
            'criteria_min' => 'nullable|array',
            'criteria_min.*' => 'required|integer|min:0|max:100',
        ]);

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
        ]);

        // Sync criteria
        $program->criteria()->delete();
        if ($request->has('criteria_name') && is_array($request->criteria_name)) {
            foreach ($request->criteria_name as $idx => $name) {
                $minVal = isset($request->criteria_min[$idx]) ? (int)$request->criteria_min[$idx] : 0;
                $program->criteria()->create([
                    'nama_kriteria' => $name,
                    'nilai_minimum' => $minVal,
                ]);
            }
        }

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

    public function updateDssConfig(Request $request)
    {
        $request->validate([
            'weight_hafalan' => 'required|integer|min:0|max:100',
            'weight_aism' => 'required|integer|min:0|max:100',
            'weight_iqro' => 'required|integer|min:0|max:100',
            'weight_calistung' => 'required|integer|min:0|max:100',
            'weight_dikte' => 'required|integer|min:0|max:100',
            'weight_kemandirian' => 'required|integer|min:0|max:100',
        ]);

        $wHafalan = (int) $request->weight_hafalan;
        $wAism = (int) $request->weight_aism;
        $wIqro = (int) $request->weight_iqro;
        $wCalistung = (int) $request->weight_calistung;
        $wDikte = (int) $request->weight_dikte;
        $wKemandirian = (int) $request->weight_kemandirian;

        $totalWeight = $wHafalan + $wAism + $wIqro + $wCalistung + $wDikte + $wKemandirian;
        if ($totalWeight !== 100) {
            return back()->with('error', "Total bobot nilai harus sama dengan 100%! (Total saat ini: {$totalWeight}%)")->withInput();
        }

        // Store in DB
        $setting = \App\Models\PmbmSetting::first();
        if (!$setting) {
            $setting = new \App\Models\PmbmSetting();
            $setting->registration_open = true;
            $setting->current_angkatan = date('Y');
        }

        $setting->dss_weights = [
            'weights' => [
                'hafalan' => $wHafalan,
                'aism' => $wAism,
                'iqro' => $wIqro,
                'calistung' => $wCalistung,
                'dikte' => $wDikte,
                'kemandirian' => $wKemandirian,
            ]
        ];
        
        $setting->save();

        // Also save to BobotPenilaian for backwards compatibility
        $bobot = \App\Models\BobotPenilaian::first();
        if (!$bobot) {
            $bobot = new \App\Models\BobotPenilaian();
        }
        $bobot->bobot_hafalan = $wHafalan;
        $bobot->bobot_aism = $wAism;
        $bobot->bobot_irqa = $wIqro;
        $bobot->bobot_calistung = $wCalistung;
        $bobot->bobot_dikte = $wDikte;
        $bobot->bobot_kemandirian = $wKemandirian;
        $bobot->save();

        // Trigger mass recalculation
        \App\Services\DssService::recalculateAll();

        return redirect()->route('tata_usaha.dss.index')->with('success', 'Konfigurasi predikat batas angka dan bobot perhitungan DSS berhasil diperbarui!');
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
     * Resolve the period to use for data queries.
     * If 'tahun' is provided in the request, find the matching period by year.
     * Otherwise, fall back to the currently active period.
     */
    private function resolvePeriod(Request $request): ?PeriodePendaftaran
    {
        if ($request->filled('tahun')) {
            return PeriodePendaftaran::where('tahun', $request->tahun)->first();
        }
        return PeriodePendaftaran::where('status', 'aktif')->first();
    }

    /**
     * Get programs that belong to the active/selected period, or all programs if none specified.
     */
    private function getActivePrograms(?PeriodePendaftaran $activePeriod)
    {
        if ($activePeriod && $activePeriod->programs()->count() > 0) {
            return $activePeriod->programs;
        }
        return Program::all();
    }

    private function autoExpireWaitlists()
    {
        // Disabling 7-day automatic countdown expiration for re-registration
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
 
        return redirect()->route('tata_usaha.faqs.index')->with('success', 'FAQ baru berhasil ditambahkan.');
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
 
        return redirect()->route('tata_usaha.faqs.index')->with('success', 'FAQ berhasil diperbarui.');
    }
 
    /**
     * Delete an FAQ.
     */
    public function deleteFaq($id)
    {
        $faq = \App\Models\Faq::findOrFail($id);
        $faq->delete();
 
        return redirect()->route('tata_usaha.faqs.index')->with('success', 'FAQ berhasil dihapus.');
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
 
        return redirect()->route('tata_usaha.contacts.index')->with('success', 'Kontak/Media Sosial baru berhasil ditambahkan.');
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
 
        return redirect()->route('tata_usaha.contacts.index')->with('success', 'Kontak/Media Sosial berhasil diperbarui.');
    }
 
    /**
     * Delete a School Contact.
     */
    public function deleteContact($id)
    {
        $contact = \App\Models\SchoolContact::findOrFail($id);
        $contact->delete();
 
        return redirect()->route('tata_usaha.contacts.index')->with('success', 'Kontak/Media Sosial berhasil dihapus.');
    }



    /**
     * Publish or unpublish the graduation results.
     */
    public function publishGraduation(Request $request)
    {
        // Run pending migrations automatically
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {}

        $activePeriod = \App\Models\PeriodePendaftaran::where('status', 'aktif')->first();
        if (!$activePeriod) {
            return back()->with('error', 'Tidak ada periode pendaftaran aktif untuk mempublikasikan pengumuman.');
        }

        $activePeriod->graduation_published = !$activePeriod->graduation_published;
        $activePeriod->save();

        $status = $activePeriod->graduation_published ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Status pengumuman kelulusan berhasil {$status}!");
    }

    /**
     * Manually trigger waitlist countdown promotions.
     */
    public function triggerCountdown(Request $request)
    {
        $activePeriod = \App\Models\PeriodePendaftaran::where('status', 'aktif')->first();
        if (!$activePeriod) {
            return back()->with('error', 'Tidak ada periode pendaftaran aktif untuk memproses hitung mundur.');
        }

        // 1. Find Lulus candidates of the active period who have missed the confirm deadline
        $expiredPendaftarans = Pendaftaran::where('periode_pendaftaran_id', $activePeriod->id)
            ->where('status_kelulusan', 'lulus')
            ->where(function($q) {
                $q->whereNull('status_konfirmasi')
                  ->orWhere('status_konfirmasi', 'belum_konfirmasi');
            })
            ->whereNotNull('batas_konfirmasi')
            ->where('batas_konfirmasi', '<', now())
            ->get();

        $promotedCount = 0;

        foreach ($expiredPendaftarans as $pendaftaran) {
            // Update status to Tidak Lulus PMBM
            $pendaftaran->status_konfirmasi = 'tidak_lulus_pmbm';
            $pendaftaran->save();

            // 2. Promote the highest ranked waitlist candidate for this program
            $candidateToPromote = Pendaftaran::where('periode_pendaftaran_id', $activePeriod->id)
                ->where('id_program', $pendaftaran->id_program)
                ->where('status_kelulusan', 'cadangan')
                ->whereHas('nilaiUjian')
                ->join('dss_rankings', 'pendaftarans.id_pendaftaran', '=', 'dss_rankings.id_pendaftaran')
                ->orderBy('dss_rankings.nilai_total', 'desc')
                ->select('pendaftarans.*')
                ->first();

            if ($candidateToPromote) {
                $candidateToPromote->status_kelulusan = 'lulus';
                $candidateToPromote->peringkat_cadangan = null;
                $candidateToPromote->status_konfirmasi = 'belum_konfirmasi';
                $candidateToPromote->tanggal_kelulusan = now();
                $candidateToPromote->batas_konfirmasi = now()->addWeek(); // 1 week deadline
                $candidateToPromote->save();
                $promotedCount++;
            }
        }

        // 3. Recalculate ranking to update recommendations
        \App\Services\DssService::recalculateAll();

        return back()->with('success', "Proses hitung mundur manual selesai! " . count($expiredPendaftarans) . " siswa terlambat diubah menjadi 'Tidak Lulus PMBM' dan {$promotedCount} siswa cadangan dipromosikan.");
    }

    /**
     * Show guide management page.
     */
    public function showGuide()
    {
        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true) ?? [];
        }

        return view('master.guide', compact('content'));
    }

    /**
     * Update guide videos.
     */
    public function updateGuide(Request $request)
    {
        $request->validate([
            'guide_parent_video_url' => 'nullable|url',
            'guide_parent_video_file' => 'nullable|file|mimes:mp4,webm|max:51200', // max 50MB
            'guide_admin_video_url' => 'nullable|url',
            'guide_admin_video_file' => 'nullable|file|mimes:mp4,webm|max:51200', // max 50MB
            'guide_panitia_video_url' => 'nullable|url',
            'guide_panitia_video_file' => 'nullable|file|mimes:mp4,webm|max:51200', // max 50MB
        ]);

        $contentPath = storage_path('app/landing_content.json');
        $content = [];
        if (file_exists($contentPath)) {
            $content = json_decode(file_get_contents($contentPath), true) ?? [];
        }

        // Handle Parent Video File
        if ($request->hasFile('guide_parent_video_file')) {
            $file = $request->file('guide_parent_video_file');
            $filename = 'guide_parent_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/videos'), $filename);
            
            if (!empty($content['guide_parent_video_file']) && file_exists(public_path($content['guide_parent_video_file']))) {
                @unlink(public_path($content['guide_parent_video_file']));
            }
            $content['guide_parent_video_file'] = '/uploads/videos/' . $filename;
        }

        // Handle Admin Video File
        if ($request->hasFile('guide_admin_video_file')) {
            $file = $request->file('guide_admin_video_file');
            $filename = 'guide_admin_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/videos'), $filename);
            
            if (!empty($content['guide_admin_video_file']) && file_exists(public_path($content['guide_admin_video_file']))) {
                @unlink(public_path($content['guide_admin_video_file']));
            }
            $content['guide_admin_video_file'] = '/uploads/videos/' . $filename;
        }

        // Handle Panitia Video File
        if ($request->hasFile('guide_panitia_video_file')) {
            $file = $request->file('guide_panitia_video_file');
            $filename = 'guide_panitia_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/videos'), $filename);
            
            if (!empty($content['guide_panitia_video_file']) && file_exists(public_path($content['guide_panitia_video_file']))) {
                @unlink(public_path($content['guide_panitia_video_file']));
            }
            $content['guide_panitia_video_file'] = '/uploads/videos/' . $filename;
        }

        $content['guide_parent_video_url'] = $request->guide_parent_video_url;
        $content['guide_admin_video_url'] = $request->guide_admin_video_url;
        $content['guide_panitia_video_url'] = $request->guide_panitia_video_url;

        file_put_contents($contentPath, json_encode($content, JSON_PRETTY_PRINT));

        return back()->with('success', 'Video panduan pendaftaran dan tutorial penggunaan sistem berhasil diperbarui.');
    }
}
