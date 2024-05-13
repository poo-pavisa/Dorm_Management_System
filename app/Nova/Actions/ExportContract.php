<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Dormitory;
use App\Models\Tenant;
use App\Models\ContractRent;
use PDF;

class ExportContract extends Action
{
    use InteractsWithQueue, Queueable;

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
            $tenantId = $model->tenant_id;
            $dormitory = Dormitory::first();
            $tenant = Tenant::findOrFail($tenantId);
            $contracts = ContractRent::where('tenant_id', $tenant->id)->first();
            $date = now();
            $data = [
                'dormitory' => $dormitory,
                'title' => 'Contract Rent',
                'date' => $date,
                'tenant' => $tenant,
                'contracts' => $contracts,
            ]; 

            $content = view('contract.pdf', $data)->render();
            $pdf = PDF::loadHTML($content);

            $pdfPath = 'PDF/Contract_' . $tenantId . '.pdf';
            Storage::disk('public')->put($pdfPath, $pdf->output());

            $downloadUrl = Storage::url($pdfPath);

            return Action::download($downloadUrl, 'contract.pdf');
        }

        return Action::download(null, 'contract.pdf');

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
