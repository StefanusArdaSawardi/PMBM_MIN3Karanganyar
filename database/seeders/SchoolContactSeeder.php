<?php
 
namespace Database\Seeders;
 
use App\Models\SchoolContact;
use Illuminate\Database\Seeder;
 
class SchoolContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'platform_name' => 'Alamat',
                'value' => 'Sroyo, Kec. Jaten, Kabupaten Karanganyar, Jawa Tengah 57731',
                'link' => 'https://maps.google.com/?q=MIN+3+Karanganyar',
                'icon' => 'geo-alt'
            ],
            [
                'platform_name' => 'Telepon',
                'value' => '0812-2667-6554',
                'link' => 'tel:081226676554',
                'icon' => 'phone'
            ],
            [
                'platform_name' => 'Email',
                'value' => 'min3kra@gmail.com',
                'link' => 'mailto:min3kra@gmail.com',
                'icon' => 'envelope'
            ],
            [
                'platform_name' => 'WhatsApp',
                'value' => '0812-2667-6554',
                'link' => 'https://wa.me/6281226676554',
                'icon' => 'whatsapp'
            ],
            [
                'platform_name' => 'Instagram',
                'value' => '@min3karanganyar',
                'link' => 'https://instagram.com/min3karanganyar',
                'icon' => 'instagram'
            ],
            [
                'platform_name' => 'Facebook',
                'value' => 'MIN 3 Karanganyar',
                'link' => 'https://facebook.com/min3karanganyar',
                'icon' => 'facebook'
            ]
        ];
 
        foreach ($contacts as $contact) {
            SchoolContact::create($contact);
        }
    }
}
