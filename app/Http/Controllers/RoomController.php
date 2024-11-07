<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return Room::where('is_available', true)->get();
    }

    public function search(Request $request)
    {
        // Mendapatkan tanggal check-in dan check-out dari request
        $checkIn = Carbon::parse($request->input('check_in'));
        $checkOut = Carbon::parse($request->input('check_out'));

        // Mendapatkan waktu saat ini
        $now = Carbon::now();

        // Validasi: Pastikan tanggal check-in dan check-out tidak kurang dari tanggal saat ini
        if ($checkIn->lt($now)) {
            return response()->json(['error' => 'Tanggal check-in tidak bisa lebih rendah dari tanggal hari ini.'], 400);
        }

        if ($checkOut->lt($now)) {
            return response()->json(['error' => 'Tanggal check-out tidak bisa lebih rendah dari tanggal hari ini.'], 400);
        }

        // Validasi: Pastikan tanggal check-out tidak lebih kecil atau sama dari tanggal check-in
        if ($checkOut->lt($checkIn) || $checkOut->eq($checkIn)) {
            return response()->json(['error' => 'Tanggal check-out tidak bisa lebih kecil atau sama dari tanggal check-in.'], 400);
        }

        // Mencari kamar yang tersedia berdasarkan tanggal dan status booking
        $availableRooms = Room::where('is_available', true)
            ->whereNotIn('id', function ($query) use ($checkIn, $checkOut, $now) {
                $query->select('room_id')
                    ->from('bookings')
                    ->where(function ($query) use ($checkIn, $checkOut) {
                        // Memeriksa jika ada tumpang tindih tanggal
                        $query->whereBetween('check_in', [$checkIn, $checkOut])
                            ->orWhereBetween('check_out', [$checkIn, $checkOut])
                            ->orWhere(function ($query) use ($checkIn, $checkOut) {
                                $query->where('check_in', '<', $checkIn)
                                    ->where('check_out', '>', $checkOut);
                            });
                    })
                    // Memeriksa status booking
                    ->where(function ($query) use ($now) {
                        $query->where('status', '!=', 'canceled') // Kamar hanya dianggap ter-booking jika statusnya bukan canceled
                            ->orWhere(function ($query) use ($now) {
                                // Jika pembayaran masih dalam status 'unpaid' tapi sudah melewati waktu pembayaran
                                $query->where('payment_status', 'unpaid')
                                    ->where(function ($query) use ($now) {
                                        // Memeriksa jika batas waktu pembayaran sudah terlewati
                                        $query->where('payment_due_at', '<', $now)
                                            ->orWhereNull('payment_due_at'); // Jika tidak ada batas waktu pembayaran
                                    });
                            });
                    });
            })
            ->get();

        return response()->json($availableRooms);
    }
}
