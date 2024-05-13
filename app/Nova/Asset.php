<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Boolean;
use Carbon\Carbon;
use App\Nova\Metrics\Normal;
use App\Nova\Metrics\Damaged;

class Asset extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Asset>
     */
    public static $model = \App\Models\Asset::class;

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
        'name', 'room.room_no'
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
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($room) {
                    return $room->room_no;
                })
                ->textAlign('center'),

            Text::make('Name')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->textAlign('center'),
            
            Currency::make('Damage Price' ,'damage_price')
                ->sortable()
                ->showOnPreview()
                ->rules('required', 'numeric')
                ->textAlign('center'),
            
            Image::make('Image', 'image')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image');
                    $roomNo = $model->room->room_no;
                    $currentDate = Carbon::now()->format('Ymd_His');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'asset_' . 'room' . $roomNo . '_' . $currentDate . '.' . $extension; 
                    $path = $file->storeAs(
                        'images/asset',
                        $filename,
                        'public'
                    );
                    return [
                        'image' => $path,
                    ];
                })
                ->disk('public')
                ->showOnpreview()
                ->textAlign('center')
                ->indexWidth(100)
                ->detailWidth(200),

            Boolean::make('Status')
                ->default(true)
                ->showOnPreview()
                ->required()
                ->textAlign('center'),

            Boolean::make('Published', 'is_published')
                ->default(true)
                ->showOnPreview()
                ->required()
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
            Normal::make(),
            Damaged::make(),
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
