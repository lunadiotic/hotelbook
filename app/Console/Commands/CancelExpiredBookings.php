<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Update bookings that are unpaid and past the payment_due_at time
        Booking::where('payment_status', 'unpaid')
            ->where('status', 'pending')
            ->where('payment_due_at', '<', $now)
            ->chunk(100, function ($bookings) {
                foreach ($bookings as $booking) {
                    $booking->update(['status' => 'canceled']);
                }
            });

        Log::info('Job dispatched successfully.');
    }
}
