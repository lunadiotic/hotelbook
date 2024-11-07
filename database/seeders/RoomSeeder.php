<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'name' => 'Standard Room',
                'price' => 500_000.00,
                'is_available' => true,
            ],
            [
                'name' => 'Deluxe Room',
                'price' => 800_000.00,
                'is_available' => true,
            ],
            [
                'name' => 'Presidential Suite',
                'price' => 1_500_000.00,
                'is_available' => false, // Room tidak tersedia
            ],
            [
                'name' => 'Family Room',
                'price' => 750_000.00,
                'is_available' => true,
            ],
            [
                'name' => 'Business Suite',
                'price' => 1_200_000.00,
                'is_available' => true,
            ],
            [
                'name' => 'Economy Room',
                'price' => 300_000.00,
                'is_available' => true,
            ]
        ]);
    }
}
