<?php

namespace App\Observers;

use App\Models\ServiceRequest;
use Laravel\Nova\Notifications\NovaNotification;

class ServiceObserver
{
    /**
     * Handle the ServiceRequest "created" event.
     */
    public function created(ServiceRequest $serviceRequest): void
    {
        $this->getNovaNotification($serviceRequest, 'New Request: ' , 'success');
    }

    /**
     * Handle the ServiceRequest "updated" event.
     */
    public function updated(ServiceRequest $serviceRequest): void
    {
        $this->getNovaNotification($serviceRequest, 'Updated Request: ' , 'info');
    }

    /**
     * Handle the ServiceRequest "deleted" event.
     */
    public function deleted(ServiceRequest $serviceRequest): void
    {
        $this->getNovaNotification($serviceRequest, 'Deleted Request: ' , 'error');

    }

    /**
     * Handle the ServiceRequest "restored" event.
     */
    public function restored(ServiceRequest $serviceRequest): void
    {
        $this->getNovaNotification($serviceRequest, 'Restored Request: ' , 'success');
    }

    /**
     * Handle the ServiceRequest "force deleted" event.
     */
    public function forceDeleted(ServiceRequest $serviceRequest): void
    {
        $this->getNovaNotification($serviceRequest, 'Forece Deleted Request: ' , 'error');
    }

    private function getNovaNotification($serviceRequest, $message, $type): void
    {
        foreach(ServiceRequest::all() as $s) {
            $s->notify(NovaNotification::make()
                    ->message($message . '' . $serviceRequest->request_ref)
                    ->icon('inbox-in')
                    ->type($type));
        }
    }
}
