<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Notifications\InvoiceNotification;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function updated(Invoice $invoice): void
    {
      
      $user = $invoice->tenant->user;
        
      if ($user) {
          $user->notify(new InvoiceNotification([
              'hi' => "Hey, {$user->name}"
          ]));
      }
    }

    
}
