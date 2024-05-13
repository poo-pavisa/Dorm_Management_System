<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\PostComment;
use App\Nova\Metrics\AllComments;

class Comment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Comment>
     */
    public static $model = \App\Models\Comment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'content';

    public function subtitle() {
        return "Post: {$this->post->title}";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'content',
    ];

    public static $clickAction = 'edit';


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

            BelongsTo::make('Post')
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($post) {
                    return $post->title;
                }),

            BelongsTo::make('User')
                ->sortable()
                ->showOnPreview()
                ->showOnDetail()
                ->exceptOnForms(),

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
            AllComments::make(),
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
        return [
            PostComment::make(),
        ];
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
