<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Illuminate\Support\Str;
use App\Nova\Metrics\AvailableRooms;
use App\Nova\Metrics\UnAvailableRooms;

class Room extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Room>
     */
    public static $model = \App\Models\Room::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'room_no';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'room_no',
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
            Number::make('Room No.' , 'room_no')
                ->rules('required', 'numeric')
                ->creationRules('unique:rooms,room_no,NULL,id,floor_id,'.$this->floor_id)
                ->updateRules('unique:rooms,room_no,{{resourceId}},id,floor_id,'.$this->floor_id)
                ->placeholder('Room Number')
                ->showOnPreview()
                ->sortable()
                ->textAlign('center'),

            BelongsTo::make('Floor')
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($floor) {
                    return $floor->floor_no;
                }),

            Currency::make('Monthly Rate', 'monthly_rate')
                ->rules('required', 'numeric')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center'),

            Currency::make('Security Deposit', 'security_deposit')
                ->rules('required', 'numeric')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center'),

            Currency::make('Deposit', 'deposit')
                ->rules('required', 'numeric')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center'),
            
            Textarea::make('Detail', 'detail')
                ->showOnPreview()
                ->textAlign('center'),

            Image::make('Image', 'image')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image');
                    $roomNo = $model->room_no;
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'room' . $roomNo . '.' . $extension;
                    $path = $file->storeAs(
                        'images/room',
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

            Boolean::make('Available', 'is_available')
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
            
            HasMany::make('Room Galleries', 'room_galleries'),
            
            HasMany::make('Assets', 'assets'),

            HasOne::make('Tenant', 'tenant'),
            
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
            AvailableRooms::make(),
            UnAvailableRooms::make(),
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
