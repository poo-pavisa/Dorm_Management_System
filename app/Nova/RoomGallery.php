<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Outl1ne\NovaSortable\Traits\HasSortableRows;
use Carbon\Carbon;



class RoomGallery extends Resource
{

    use HasSortableRows;


    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\RoomGallery>
     */
    public static $model = \App\Models\RoomGallery::class;

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
            Number::make('sort_order')
                ->onlyOnIndex()
                ->sortable()
                ->textAlign('center'),
                    
            BelongsTo::make('Room')
                ->sortable()
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($room) {
                    return $room->room_no;
                })
                ->textAlign('center'),

            Image::make('Image', 'image')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image');
                    $roomNo = $model->room->room_no;
                    $currentDate = Carbon::now()->format('Ymd_His');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'room' . $roomNo . '_' . $currentDate . '.' . $extension; 
                    $path = $file->storeAs(
                        'images/gallery',
                        $filename,
                        'public'
                    );
                    return [
                        'image' => $path,
                    ];
                })
                ->disk('public')
                ->showOnPreview()
                ->required()
                ->textAlign('center')
                ->indexWidth(100)
                ->detailWidth(200),

            Boolean::make('Status', 'is_published')
                ->default(true)
                ->showOnPreview()
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
