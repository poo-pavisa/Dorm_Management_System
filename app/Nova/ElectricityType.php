<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;


class ElectricityType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ElectricityType>
     */
    public static $model = \App\Models\ElectricityType::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'dormitory.name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'dormitory.name', 'price_per_unit' , 'type'
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
            BelongsTo::make('Dormitory')
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($dorm) {
                    return $dorm->name;
                })
                ->textAlign('center'),

            Select::make('Type')
                ->required()
                ->sortable()
                ->options([
                'Flat Rate' => 'Flat Rate',
                'Base On Meter' => 'Base On Meter',
                ])
                ->textAlign('center'),

            Currency::make('Price Per Unit' , 'price_per_unit')
                ->showOnPreview()
                ->rules('required', 'numeric')
                ->sortable()
                ->textAlign('center'),

            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })
                ->onlyOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })
                ->onlyOnPreview(),
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
        return [];
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
