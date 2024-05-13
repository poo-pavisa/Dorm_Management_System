<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use App\Notifications\InvoiceNotification;

class PublishedInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all invoice to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $invoices = Invoice::where('is_published', 0)->get();

        foreach ($invoices as $invoice) {
            $invoice->update(['is_published' => 1]);

            $user = $invoice->tenant->user;
            
            if ($user) {
                $user->notify(new InvoiceNotification([
                    'hi' => "Hey, {$user->name}"
                ]));
            }
        }
        
        $this->info('All invoices have been published successfully.');
    }

}
