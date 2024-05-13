<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Timothyasp\Badge\Badge;
use App\Nova\Metrics\PaymentReceivedBooking;
use App\Nova\Metrics\CompletedBooking;
use App\Nova\Metrics\CancelledBooking;

class Booking extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Booking>
     */
    public static $model = \App\Models\Booking::class;

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
        'booking_ref' , 'first_name' , 'last_name'
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
                ->showOnPreview()
                ->withoutTrashed()
                ->relatableQueryUsing(function (NovaRequest $request,  $query) {
                    $query->where('is_available', 1);
                })
                ->displayUsing(function ($room) {
                    return $room->room_no;
                })
                ->textAlign('center'),
            
            BelongsTo::make('User')
                ->sortable()
                ->withoutTrashed()
                ->showOnDetail()
                ->showOnPreview(),
                        
            Text::make('Booking Ref', 'booking_ref')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->sortable()
                ->textAlign('center')
                ->showOnPreview(),
            
            Text::make('First Name' , 'first_name')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->textAlign('center'),

            Text::make('Last Name' , 'last_name')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->textAlign('center'),

            Number::make('Phone')
                ->showOnPreview()
                ->hideFromIndex()
                ->rules('required', 'numeric')
                ->textAlign('center'),

            Select::make('Gender')
                ->required()
                ->sortable()
                ->options([
                'Male' => 'Male',
                'Female' => 'Female',
                ])
                ->textAlign('center'),
            
            Date::make('Move In Date' , 'move_in_date')
                ->showOnPreview()
                ->required()
                ->sortable()
                ->textAlign('center'),     

            Text::make('Note')
                ->onlyOnDetail()
                ->textAlign('center'),

            Badge::make('Booking Channel' ,'booking_channel')
                ->sortable()
                ->textAlign('center')
                ->showOnPreview()
                ->showOnDetail()
                ->exceptOnForms()
                ->textAlign('center')
                ->options([
                    '0' => 'Online',
                    '1' => 'Walk-in',
                ])
                ->colors([
                    'Online' => '#235D3A',
                    'Walk-in' => '#4691D3',
                ]),

            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),

            HasMany::make('Bill Bookings', 'bill_booking'),

            Badge::make('Status')
                ->required()
                ->sortable()
                ->showOnPreview()
                ->showOnDetail()
                ->exceptOnForms()
                ->textAlign('center')
                ->options([
                    '0' => 'Pending',
                    '1' => 'Payment Received',
                    '2' => 'Completed',
                    '3' => 'Cancelled',
                ])
                ->colors([
                    'Pending' => '#fac240',
                    'Payment Received' => '#4691D3',
                    'Completed' => '#235D3A',
                    'Cancelled' => '#ff0000',
                ]),
                
            Boolean::make('Sent' ,'is_sent')
                ->textAlign('center')
                ->exceptOnForms()
                ->showOnPreview()
                ->showOnDetail(),
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
            PaymentReceivedBooking::make(),
            CompletedBooking::make(),
            CancelledBooking::make(),
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
