<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;

class Reply extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Reply>
     */
    public static $model = \App\Models\Reply::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'service_request.subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'service_request.subject',
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
            Text::make('Content')
            ->sortable()
            ->rules('required', 'max:255')
            ->showOnPreview(),

        BelongsTo::make('Service Request' , 'service_request')
            ->sortable()
            ->showOnPreview()
            ->withoutTrashed()
            ->displayUsing(function ($service) {
                return $service->subject;
            }),

        BelongsTo::make('Admin')
            ->sortable()
            ->hideWhenCreating()
            ->hideWhenUpdating(), 

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
