<?php

namespace App\Observers;

use App\Models\BillBooking;
use Laravel\Nova\Notifications\NovaNotification;

class BillBookingObserver
{
    /**
     * Handle the BillBooking "created" event.
     */
    public function created(BillBooking $billBooking): void
    {
        $this->getNovaNotification($billBooking, 'New Bill For: ' , 'success');
    }

    /**
     * Handle the BillBooking "updated" event.
     */
    public function updated(BillBooking $billBooking): void
    {
        $this->getNovaNotification($billBooking, 'Updated Bill For: ' , 'info');
    }

    /**
     * Handle the BillBooking "deleted" event.
     */
    public function deleted(BillBooking $billBooking): void
    {
        $this->getNovaNotification($billBooking, 'Deleted Bill For: ' , 'error');
    }

    /**
     * Handle the BillBooking "restored" event.
     */
    public function restored(BillBooking $billBooking): void
    {
        $this->getNovaNotification($billBooking, 'Restored Bill For: ' , 'success');
    }

    /**
     * Handle the BillBooking "force deleted" event.
     */
    public function forceDeleted(BillBooking $billBooking): void
    {
        $this->getNovaNotification($billBooking, 'Forece Deleted Bill For: ' , 'error');
    }

    private function getNovaNotification($billBooking, $message, $type): void
    {
        foreach(BillBooking::all() as $bb) {
            $bb->notify(NovaNotification::make()
                    ->message($message . '' . $billBooking->booking->booking_ref)
                    ->icon('cash')
                    ->type($type));
        }
    }
}
