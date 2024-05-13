<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasOne;
use Sietse85\NovaButton\Button;
use Laravel\Nova\Actions\Action;
use App\Nova\Actions\ApproveBill;
use App\Nova\Metrics\TotalDeposit;
use App\Nova\Metrics\ApprovedBooking;
use App\Nova\Metrics\UnApprovedBooking;

class BillBooking extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\BillBooking>
     */
    public static $model = \App\Models\BillBooking::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            BelongsTo::make('Booking')
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($booking) {
                    return $booking->booking_ref;
                })
                ->textAlign('center'),

            Number::make('Deposit')
                ->showOnPreview()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->textAlign('center'),

            Image::make('Slip')
                ->store(function (Request $request, $model) {
                    $file = $request->file('slip');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'slip_' . $model->booking->booking_ref . '.' . $extension;
                    $path = $file->storeAs(
                        'images/slip/booking',
                        $filename,
                        'public'
                    );
                    return [
                        'slip' => $path,
                    ];
                })
                ->disk('public')
                ->showOnpreview()
                ->required()
                ->textAlign('center')
                ->indexWidth(100)
                ->detailWidth(200),
            
            Text::make('Booking Receipt Ref', 'booking_receipt_ref')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->textAlign('center'),

            Boolean::make('Approved', 'is_approved')
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
            
            HasOne::make('Contract Rent' , 'contract_rent'),

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
            TotalDeposit::make(),
            ApprovedBooking::make(),
            UnApprovedBooking::make(),
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
        return [
            ApproveBill::make()->showOnTableRow()->canSee(function ($request) {
                return !$this->is_approved ;
            }),
        ];
    }
}
