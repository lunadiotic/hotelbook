<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // User pertama: Admin
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('adminpassword'),  // Gantilah dengan password yang aman
                'is_admin' => true,  // Menandakan bahwa ini adalah admin
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // User kedua: Pengguna biasa
            [
                'name' => 'User One',
                'email' => 'user1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('userpassword1'),
                'is_admin' => false,
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // User ketiga: Pengguna biasa
            [
                'name' => 'User Two',
                'email' => 'user2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('userpassword2'),
                'is_admin' => false,
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // User keempat: Pengguna biasa
            [
                'name' => 'User Three',
                'email' => 'user3@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('userpassword3'),
                'is_admin' => false,
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
