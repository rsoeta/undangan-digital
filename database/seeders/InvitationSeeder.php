<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invitation;

class InvitationSeeder extends Seeder
{
    public function run(): void
    {
        $invitation = Invitation::create([
            'slug' => 'rian-lisna',
            'theme' => 'tema-satu',
            'groom_nickname' => 'Rian',
            'groom_fullname' => 'Rian Sutarsa',
            'groom_father' => 'Bapak Fulan',
            'groom_mother' => 'Ibu Fulanah',
            'bride_nickname' => 'Lisna',
            'bride_fullname' => 'Lisnawati',
            'bride_father' => 'Bapak Fulan',
            'bride_mother' => 'Ibu Fulanah',
            'quote' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri...',
        ]);

        // Dummy Acara
        $invitation->events()->createMany([
            [
                'name' => 'Akad Nikah',
                'start_time' => '2026-10-10 08:00:00',
                'end_time' => '2026-10-10 10:00:00',
                'location_name' => 'Masjid Agung',
                'location_address' => 'Jl. Raya Utama No. 1, Jawa Barat',
            ],
            [
                'name' => 'Resepsi',
                'start_time' => '2026-10-10 11:00:00',
                'end_time' => '2026-10-10 15:00:00',
                'location_name' => 'Gedung Serbaguna',
                'location_address' => 'Jl. Raya Utama No. 2, Jawa Barat',
            ]
        ]);

        // Dummy Love Story
        $invitation->stories()->create([
            'title' => 'Pertama Bertemu',
            'date' => '2025-05-28',
            'description' => 'Kami bertemu pertama kali di sebuah acara komunitas.',
            'sort_order' => 1
        ]);
    }
}
