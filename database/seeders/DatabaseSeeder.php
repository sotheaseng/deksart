<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hotel.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create frontdesk user
        User::create([
            'name' => 'Front Desk Staff',
            'email' => 'frontdesk@hotel.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'frontdesk',
        ]);

        // Create housekeeper user
        User::create([
            'name' => 'Housekeeper Staff',
            'email' => 'housekeeper@hotel.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'housekeeper',
        ]);

        // Create sample rooms
        $roomTypes = ['single', 'double', 'suite', 'deluxe'];
        $prices = [100, 150, 300, 500];

        for ($i = 101; $i <= 120; $i++) {
            $typeIndex = array_rand($roomTypes);
            Room::create([
                'room_number' => (string) $i,
                'room_type' => $roomTypes[$typeIndex],
                'price_per_night' => $prices[$typeIndex],
                'status' => 'available',
                'description' => "Room {$i} - " . ucfirst($roomTypes[$typeIndex]) . " room with modern amenities",
                'amenities' => ['wifi', 'tv', 'air_conditioning', 'mini_bar'],
            ]);
        }
    }
}
