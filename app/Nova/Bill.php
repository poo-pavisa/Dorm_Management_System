<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Boolean;
use App\Nova\Actions\ApproveInvoice;
use App\Nova\Metrics\Total;
use App\Nova\Metrics\ApprovedBill;
use App\Nova\Metrics\UnApprovedBill;

class Bill extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Bill>
     */
    public static $model = \App\Models\Bill::class;

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
            BelongsTo::make('Invoice')
                ->sortable()
                ->withoutTrashed()
                ->showOnPreview()
                ->displayUsing(function ($invoice) {
                    return $invoice->invoice_ref;
                })
                ->textAlign('center'),
            
            Currency::make('Amount')
                ->sortable()
                ->showOnPreview()
                ->textAlign('center')
                ->exceptOnForms(),

            Image::make('Slip')
                ->store(function (Request $request, $model) {
                    $file = $request->file('slip');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'slip_' . $model->invoice->invoice_ref . '.' . $extension;
                    $path = $file->storeAs(
                        'images/slip',
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

            Text::make('Invoice Receipt Ref', 'invoice_receipt_ref')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->textAlign('center'),

            Boolean::make('Approved', 'is_approved')
                ->default(true)
                ->showOnPreview()
                ->textAlign('center'),

            
            Text::make('Created At', function () {
                return optional($this->created_at)->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
                    
            Text::make('Updated At', function () {
                return optional($this->updated_at)->format('Y-m-d H:i:s');
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
            Total::make(),
            ApprovedBill::make(),
            UnApprovedBill::make(),
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
            ApproveInvoice::make()->showOnTableRow()->canSee(function ($request) {
                return !$this->is_approved;
            }),
        ];
    }
}
