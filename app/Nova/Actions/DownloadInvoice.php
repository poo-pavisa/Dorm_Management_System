<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Invoice;
use App\Models\Dormitory;
use App\Models\AdditionalRate;
use Illuminate\Support\Facades\Storage;
use PDF;

class DownloadInvoice extends Action
{
    use InteractsWithQueue, Queueable;

    public function name()
    {
        return __('Export Invoice');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $invoiceId = $model->id;
            $dormitory = Dormitory::first();
            $invoice = Invoice::find($invoiceId);
            $additionals = AdditionalRate::where('invoice_id', $invoiceId)->get();
            $date = now();
            $data = [
                'dormitory' => $dormitory,
                'date' => $date,
                'invoice' => $invoice,
                'additionals' => $additionals,
            ]; 
    
            $content = view('invoice.pdf', $data)->render();
            $pdf = PDF::loadHTML($content);
    
            $pdfPath = 'PDF/Invoice_' . $invoiceId . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());
    
            $downloadUrl = Storage::url($pdfPath);
    
            return Action::download($downloadUrl, 'invoice.pdf');
        }
    
        return Action::download(null, 'invoices.pdf');
    }
    


    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
