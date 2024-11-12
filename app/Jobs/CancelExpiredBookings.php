<?php

namespace App\Jobs;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelExpiredBookings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
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
    }
}
