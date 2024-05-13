<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use App\Nova\Metrics\TotalElectricityUsage;

class ElectricityMeter extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ElectricityMeter>
     */
    public static $model = \App\Models\ElectricityMeter::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'room.room_no';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'room.room_no',
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
            
            BelongsTo::make('Room')
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($room) {
                    return $room->room_no;
                })
                ->relatableQueryUsing(function (NovaRequest $request, $query) {
                    $query->whereHas('tenant');
                })
                ->textAlign('center'),

            BelongsTo::make('Electricity Type' , 'electricity_type')
                ->sortable()
                ->showOnPreview()
                ->exceptOnForms()
                ->withoutTrashed()
                ->displayUsing(function ($elec) {
                    return $elec->type;
                })
                ->textAlign('center'),
            

            Number::make('Start Reading' , 'start_reading')
                ->showOnPreview()
                ->exceptOnForms()
                ->textAlign('center'),

            Number::make('End Reading' , 'end_reading')
                ->showOnPreview()
                ->rules('required', 'numeric')
                ->textAlign('center'),
            
            Number::make('Quantity Consumed' , 'quantity_consumed')
                ->showOnPreview()
                ->exceptOnForms()
                ->sortable()
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
            TotalElectricityUsage::make(),
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
