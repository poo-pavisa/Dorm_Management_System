<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;


class Dormitory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Dormitory>
     */
    public static $model = \App\Models\Dormitory::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'phone',
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
            Text::make('Name')
                ->rules('required', 'max:255')
                ->creationRules('unique:dormitories,name')
                ->updateRules('unique:dormitories,name,{{resourceId}}')
                ->showOnPreview()
                ->placeholder('Dormitory Name')
                ->sortable(),

            Textarea::make('Address')
                ->rules('required', 'max:255')
                ->showOnPreview(),

            Text::make('Email')
                ->rules('required', 'email', 'max:255')
                ->showOnPreview(),

            Text::make('Phone')
                ->showOnPreview()
                ->required(),

            Number::make('Bill Date', 'bill_date')
                ->rules('required', 'numeric')
                ->showOnPreview()
                ->textAlign('center'),

            Number::make('Payment Due Date', 'payment_due_date')
                ->rules('required', 'numeric')
                ->showOnPreview()
                ->textAlign('center'),

            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),

            HasOne::make('Electricity Type' , 'electricity_type'),
            
            HasOne::make('Water Type' , 'water_type'),

            HasMany::make('Bank Accounts' , 'bank_accounts'),

            HasMany::make('Floors')->sortable(),
            
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
