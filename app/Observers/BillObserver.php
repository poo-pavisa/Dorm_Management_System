<?php

namespace App\Observers;

use App\Models\Bill;
use Laravel\Nova\Notifications\NovaNotification;

class BillObserver
{
    /**
     * Handle the Bill "created" event.
     */
    public function created(Bill $bill): void
    {
        $this->getNovaNotification($bill, 'New Bill For : ' , 'success');
    }

    /**
     * Handle the Bill "updated" event.
     */
    public function updated(Bill $bill): void
    {
        $this->getNovaNotification($bill, 'Updated Bill For: ' , 'info');
    }

    /**
     * Handle the Bill "deleted" event.
     */
    public function deleted(Bill $bill): void
    {
        $this->getNovaNotification($bill, 'Deleted Bill For: ' , 'error');
    }

    /**
     * Handle the Bill "restored" event.
     */
    public function restored(Bill $bill): void
    {
        $this->getNovaNotification($bill, 'Restored Bill For: ' , 'success');
    }

    /**
     * Handle the Bill "force deleted" event.
     */
    public function forceDeleted(Bill $bill): void
    {
        $this->getNovaNotification($bill, 'Forece Deleted Bill For: ' , 'error');
    }

    private function getNovaNotification($bill, $message, $type): void
    {
        foreach(Bill::all() as $b) {
            $b->notify(NovaNotification::make()
                    ->message($message . '' . $bill->invoice->invoice_ref)
                    ->icon('cash')
                    ->type($type));
        }
    }
}
