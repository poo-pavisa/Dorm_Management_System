<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;



class Floor extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Floor>
     */
    public static $model = \App\Models\Floor::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'floor_no';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'floor_no',
        'dormitory.name',
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
            Number::make('Floor No.' , 'floor_no')
                ->rules('required', 'numeric')
                ->creationRules('unique:floors,floor_no,NULL,id,dorm_id,'.$this->dorm_id)
                ->updateRules('unique:floors,floor_no,{{resourceId}},id,dorm_id,'.$this->dorm_id)
                ->textAlign('center')
                ->sortable()
                ->showOnPreview(),
            
            BelongsTo::make('Dormitory')
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($dorm) {
                    return $dorm->name;
                })
                ->textAlign('center'),

            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),

            HasMany::make('Rooms')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),
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
