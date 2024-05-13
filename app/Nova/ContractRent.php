<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\File;
use App\Nova\Actions\ExportContract;

class ContractRent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ContractRent>
     */
    public static $model = \App\Models\ContractRent::class;

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
            BelongsTo::make('Tenant',)
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($tenant) {
                    return $tenant->first_name . ' ' . $tenant->last_name;
                })
                ->textAlign('center'),

            BelongsTo::make('Bill Booking', 'billBooking')
                ->sortable()
                ->showOnPreview()
                ->onlyOnDetail()
                ->withoutTrashed()
                ->displayUsing(function ($billBooking) {
                    return $billBooking->booking_receipt_ref;
                })
                ->textAlign('center')
                ->nullable(),
            
            Date::make('Contract Start Date' , 'contract_start_date')
                ->required()
                ->showOnPreview()
                ->textAlign('center'),

            Number::make('Contract Duration' , 'contract_duration')
                ->textAlign('center')
                ->sortable()
                ->placeholder('Contract Duration (Month)')
                ->showOnPreview()
                ->showOnDetail()
                ->hideFromIndex()
                ->rules('required', 'numeric'),
                
            
            Date::make('Contract End Date', 'contract_end_date')
                ->exceptOnForms()
                ->textAlign('center'),

            Currency::make('Security Deposit', 'security_deposit')
                ->sortable()
                ->textAlign('center')
                ->onlyOnDetail(),
            
                
            Currency::make('Booking Deduction', 'booking_deduction')
                ->sortable()
                ->showOnPreview()
                ->exceptOnForms()
                ->onlyOnDetail()
                ->textAlign('center'),

            Date::make('Booking Payment Date' , 'booking_payment_date')
                ->exceptOnForms()
                ->showOnPreview()
                ->onlyOnDetail()
                ->textAlign('center'),

            Text::make('Booking Receipt Ref', 'booking_receipt_ref')
                ->exceptOnForms()
                ->showOnPreview()
                ->onlyOnDetail()
                ->textAlign('center'),

            Number::make('Start Water Reading' , 'start_water_reading')
                ->textAlign('center')
                ->sortable()
                ->showOnPreview()
                ->rules('required', 'numeric'),
            
            Number::make('Start Electricity Reading' , 'start_electricity_reading')
                ->textAlign('center')
                ->sortable()
                ->showOnPreview()
                ->rules('required', 'numeric'),

            File::make('image')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'Contract_' . $model->tenant->first_name.'Room_' . $model->tenant->room->room_no. '.' .  $extension;
                    $path = $file->storeAs(
                        'images/contract',
                        $filename,
                        'public'
                    );
                    return [
                        'image' => $path,
                    ];
                })
                ->disk('public')
                ->showOnpreview()
                ->showOnDetail()
                ->hideFromIndex()
                ->textAlign('center'),

            Text::make('Note')
                ->textAlign('center')
                ->showOnDetail()
                ->hideFromIndex()
                ->showOnPreview(),

            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),

            HasOne::make('Entrance Fee', 'entranceFee', EntranceFee::class)
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->nullable(),
                        
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
            ExportContract::make()->showOnTableRow(),
        ];
    }
}
