<?php

namespace App\Observers;

use App\Models\Booking;
use Laravel\Nova\Notifications\NovaNotification;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        $this->getNovaNotification($booking, 'New Booking: ' , 'success');
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        $this->getNovaNotification($booking, 'Updated Booking: ' , 'info');
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        $this->getNovaNotification($booking, 'Deleted Booking: ' , 'error');
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        $this->getNovaNotification($booking, 'Restored Booking: ' , 'success');
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        $this->getNovaNotification($booking, 'Force Deleted Booking: ' , 'error');

    }

    private function getNovaNotification($booking, $message, $type): void
    {
        foreach(Booking::all() as $b) {
            $b->notify(NovaNotification::make()
                    ->message($message . '' . $booking->booking_ref)
                    ->icon('calendar')
                    ->type($type));
        }
    }
}
