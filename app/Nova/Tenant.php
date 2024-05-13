<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;
use Carbon\Carbon;
use App\Nova\Metrics\Female;
use App\Nova\Metrics\Male;

class Tenant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Tenant>
     */
    public static $model = \App\Models\Tenant::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'firstname';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name', 'last_name' , 'room.room_no' , 'phone' , 'identification_no'
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

            BelongsTo::make('User')
                ->sortable()
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($user) {
                    return $user->name;
                })
                ->textAlign('center'),

            Text::make('First Name' , 'first_name')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->sortable()
                ->textAlign('center'),

            Text::make('Last Name' , 'last_name')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->sortable()
                ->textAlign('center'),

            Select::make('Gender')
                ->required()
                ->sortable()
                ->options([
                'Male' => 'Male',
                'Female' => 'Female',
                ])
                ->textAlign('center'),
            
            Number::make('Phone')
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('required', 'numeric')
                ->textAlign('center'),

            Number::make('Identification No.' , 'identification_no')
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('required', 'numeric')
                ->textAlign('center'),
            
            Date::make('Date Of Birth' , 'date_of_birth')
                ->showOnPreview()
                ->required()
                ->hideFromIndex()
                ->textAlign('center'),

            Text::make('Address')
                ->showOnPreview()
                ->required()
                ->hideFromIndex()
                ->textAlign('center'),
            
            Text::make('Nationality')
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('required', 'max:255')
                ->textAlign('center'),

            Image::make('Image ID Card', 'image_id_card')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image_id_card');
                    $roomNo = $model->room->room_no;
                    $currentDate = Carbon::now()->format('Ymd_His');
                    $extension = $file->getClientOriginalExtension();
                    $filename = $model->first_name .  '_' . $roomNo . '_' . $currentDate . '.' . $extension; 
                    $path = $file->storeAs(
                        'images/idcard',
                        $filename,
                        'public'
                    );
                    return [
                        'image_id_card' => $path,
                    ];
                    })
                ->disk('public')
                ->showOnpreview()
                ->textAlign('center')
                ->required(),
            
            Image::make('Image Profile', 'image_profile')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image_profile');
                    $roomNo = $model->room->room_no;
                    $currentDate = Carbon::now()->format('Ymd_His');
                    $extension = $file->getClientOriginalExtension();
                    $filename = $model->first_name .  '_' . $roomNo . '_' . $currentDate . '.' . $extension; 
                    $path = $file->storeAs(
                        'images/profile/tenant',
                        $filename,
                        'public'
                    );
                    return [
                        'image_profile' => $path,
                    ];
                    })
                ->disk('public')
                ->showOnpreview()
                ->textAlign('center')
                ->required(),
            
            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
            
            HasOne::make('Contract Rent' , 'contract_rent'),

            HasMany::make('Invoice' , 'invoice'),
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
            Female::make(),
            Male::make(),
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
