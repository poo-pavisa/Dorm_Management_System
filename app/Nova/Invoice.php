<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;
use Timothyasp\Badge\Badge;
use App\Nova\Metrics\TotalAmount;
use App\Nova\Metrics\AwaitingPayment;
use App\Nova\Metrics\PendingReview;
use App\Nova\Metrics\PaidInvoice;
use App\Nova\Metrics\OutstandingInvoice;
use App\Nova\Actions\DownloadInvoice;

class Invoice extends Resource

{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Invoice>
     */
    public static $model = \App\Models\Invoice::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            BelongsTo::make('Room', 'tenant','App\Nova\Tenant')
                ->sortable()
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($tenant) {
                    return $tenant->room->room_no;
                })
                ->textAlign('center'),

            Text::make('Invoice Ref', 'invoice_ref')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->textAlign('center'),
    
            Text::make('Date Invoice', function () {
                return $this->created_at->format('F Y');
            })
            ->showOnPreview()
            ->showOnDetail()
            ->textALign('center'),

            Currency::make('Room Rate','room_rate')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center')
                ->onlyOnDetail()
                ->showOnPreview(),

            Currency::make('Water Rate','water_rate')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center')
                ->onlyOnDetail()
                ->showOnPreview(),

            Currency::make('Electricity Rate','electricity_rate')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center')
                ->onlyOnDetail()
                ->showOnPreview(),
            
            Currency::make('Total Amount','total_amount')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center')
                ->exceptOnForms(),
            
            Badge::make('Status')
                ->sortable()
                ->default($this->status)
                ->options([
                    '0' => 'Awaiting Payment',
                    '1' => 'Pending Review',
                    '2' => 'Paid',
                    '3' => 'Outstanding',
                ])
                ->colors([
                    'Awaiting Payment' => '#fac240',
                    'Pending Review' => '#4691D3',
                    'Paid' => '#235D3A',
                    'Outstanding' => '#ff0000',
                ])
                ->exceptOnForms(),


            Boolean::make('Published', 'is_published')
                ->default(true)
                ->showOnPreview()
                ->textAlign('center'),


            HasMany::make('Additional Rate' , 'additional_rates'),

            HasOne::make('Bill'),
            
            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
            
    
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            TotalAmount::make(),
            AwaitingPayment::make(),
            PendingReview::make(),
            PaidInvoice::make(),
            OutstandingInvoice::make(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            DownloadInvoice::make()->showOnTableRow(),
        ];
    }
}
