<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;

class InvoicPayCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Pay Invoice';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unpaidInvoices = Invoice::where('status', 0)->get();

        foreach ($unpaidInvoices as $invoice) {
            $invoice->status = 3;
            $invoice->save();
        }

        $this->info('Check unpaid invoice successfully.');
    }
}
