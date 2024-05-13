<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Metrics\AllPosts;
use Carbon\Carbon;



class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Post>
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public function subtitle() {
        return "Conntent: {$this->content}";
    }

    public static $globalSearchResults = 10;

    
    /**
     * The columns that should be searched.
     *
     * @var array
     */

    public static $search = [
        'title'
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
            Text::make('Title')
                ->showOnPreview()
                ->rules('required', 'max:255'),
        
            Textarea::make('Content')
                ->required()
                ->showOnPreview(),

            Image::make('Image', 'image')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image');
                    $title = $model->title;
                    $currentDate = Carbon::now()->format('Ymd_His');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'post' . $title . '_' . $currentDate . '.' . $extension; 
                    $path = $file->storeAs(
                        'images/post',
                        $filename,
                        'public'
                    );
                    return [
                        'image' => $path,
                    ];
                })
                ->disk('public')
                ->showOnPreview()
                ->textAlign('center')
                ->indexWidth(100)
                ->detailWidth(200),

            Boolean::make('Comment', 'status_comment')
                ->default(true)
                ->showOnPreview(),

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
                
            HasMany::make('Comments'),
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
            AllPosts::make(),
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
