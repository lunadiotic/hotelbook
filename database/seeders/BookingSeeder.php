<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookings')->insert([
            // Booking pertama: Confirmed dan dibayar
            [
                'user_id' => 2,
                'room_id' => 1,
                'check_in' => Carbon::now()->addDays(1)->toDateString(),
                'check_out' => Carbon::now()->addDays(3)->toDateString(),
                'total_price' => 1500000.00,
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_due_at' => null,  // Tidak ada batas waktu pembayaran karena sudah dibayar
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Booking kedua: Pending dan belum dibayar, payment_due_at dalam 1 menit
            [
                'user_id' => 3,
                'room_id' => 2,
                'check_in' => Carbon::now()->addDays(2)->toDateString(),
                'check_out' => Carbon::now()->addDays(4)->toDateString(),
                'total_price' => 2000000.00,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_due_at' => Carbon::now()->addMinutes(1),  // Batas pembayaran 1 menit setelah booking
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Booking ketiga: Canceled karena gagal bayar (payment_due_at sudah lewat)
            [
                'user_id' => 2,
                'room_id' => 3,
                'check_in' => Carbon::now()->addDays(3)->toDateString(),
                'check_out' => Carbon::now()->addDays(5)->toDateString(),
                'total_price' => 1800000.00,
                'status' => 'canceled',
                'payment_status' => 'unpaid',
                'payment_due_at' => Carbon::now()->subMinutes(30),  // Sudah melewati waktu batas pembayaran
                'created_at' => Carbon::now()->subMinutes(30),
                'updated_at' => Carbon::now()->subMinutes(30),
            ],

            // Booking keempat: Canceled secara manual oleh user
            [
                'user_id' => 3,
                'room_id' => 4,
                'check_in' => Carbon::now()->addDays(4)->toDateString(),
                'check_out' => Carbon::now()->addDays(6)->toDateString(),
                'total_price' => 2500000.00,
                'status' => 'canceled',
                'payment_status' => 'unpaid',
                'payment_due_at' => Carbon::now()->addMinutes(1),  // Masih dalam waktu pembayaran
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Booking kelima: Pending dan belum dibayar, payment_due_at dalam 1 menit
            [
                'user_id' => 4,
                'room_id' => 5,
                'check_in' => Carbon::now()->addDays(5)->toDateString(),
                'check_out' => Carbon::now()->addDays(7)->toDateString(),
                'total_price' => 2200000.00,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_due_at' => Carbon::now()->addMinutes(1),  // Batas pembayaran 1 menit setelah booking
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
