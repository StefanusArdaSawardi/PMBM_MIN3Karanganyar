<?php
 
namespace Database\Seeders;
 
use App\Models\Faq;
use Illuminate\Database\Seeder;
 
class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa saja syarat dokumen untuk pendaftaran?',
                'answer' => 'Syarat dokumen utama yang perlu diunggah antara lain: Pas Foto Berwarna, Kartu Keluarga (KK), Akta Kelahiran, dan Kartu Identitas Anak (KIA) jika ada. Semua berkas diunggah dalam format PDF atau gambar (Maksimal 5MB).'
            ],
            [
                'question' => 'Bagaimana alur pendaftaran PMBM?',
                'answer' => 'Alur pendaftaran terdiri dari: 1) Isi formulir pendaftaran online di website, 2) Verifikasi berkas oleh Admin, 3) Pengecekan berkas fisik onsite di sekolah, 4) Tahap seleksi tes dan wawancara, 5) Penetapan kelulusan, dan 6) Konfirmasi/Daftar Ulang secara onsite.'
            ],
            [
                'question' => 'Apa saja kategori program kelas yang tersedia?',
                'answer' => 'Tersedia 3 pilihan program kelas: 1) Program Khusus (Tahfidz & fokus hafalan Quran), 2) Program Unggulan (fokus Sains, riset & Kurikulum IT), dan 3) Program Fullday (fokus Karakter Islami, kepemimpinan & minat bakat).'
            ],
            [
                'question' => 'Kapan pengumuman kelulusan diumumkan?',
                'answer' => 'Pengumuman kelulusan dapat dipantau langsung di halaman website PMBM pada menu "Cek Kelulusan" sesuai jadwal periode aktif yang ditentukan sekolah.'
            ],
            [
                'question' => 'Bagaimana jika pendaftaran saya ditolak?',
                'answer' => 'Jika status berkas online Anda ditolak oleh Admin, Anda akan melihat catatan alasan penolakan. Anda dapat login kembali menggunakan nomor pendaftaran dan NISN untuk mengoreksi berkas selama masa pendaftaran masih aktif.'
            ]
        ];
 
        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
