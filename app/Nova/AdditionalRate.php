<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use App\Nova\Metrics\TotalAdditionalRates;

class AdditionalRate extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AdditionalRate>
     */
    public static $model = \App\Models\AdditionalRate::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'invoice.invoice_ref', 'invoice.tenant.room.room_no' , 'description'
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
            BelongsTo::make('Invoice')
                ->sortable()
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($invoice) {
                    return $invoice->invoice_ref;
                })
                ->textAlign('center'),
            
            Text::make('Room No.', function () {
                    return $this->invoice->tenant->room->room_no;
                })
                ->exceptOnForms()
                ->textAlign('center'),

            Text::make('Description')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->textAlign('center'),

            Currency::make('Additional Rate','additional_rate')
                ->sortable()
                ->showOnPreview()
                ->rules('required','numeric')
                ->textAlign('center'),
            
            
            Text::make('Created At', function () {
                    return $this->created_at->format('Y-m-d H:i:s');
                    })->onlyOnDetail()
                    ->showOnPreview(),
                    
            Text::make('Updated At', function () {
                    return $this->updated_at->format('Y-m-d H:i:s');
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
            TotalAdditionalRates::make(),
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
        return [];
    }
}
