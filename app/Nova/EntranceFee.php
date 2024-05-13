<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Currency;
use App\Nova\Metrics\TotalSecurityDeposit;

class EntranceFee extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\EntranceFee>
     */
    public static $model = \App\Models\EntranceFee::class;

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

            BelongsTo::make('Contract Rent', 'contract_rent')
            ->sortable()
            ->showOnPreview()
            ->showOnDetail()
            ->exceptOnforms()
            ->withoutTrashed()
            ->displayUsing(function ($contract_rent) {
                return $contract_rent->tenant->first_name . ' ' . $contract_rent->tenant->last_name ;
            })
            ->textAlign('center')
            ->nullable(),

                    
            Currency::make('Sum Payable', 'sum_payable')
                ->sortable()
                ->showOnPreview()
                ->showOnDetail()
                ->exceptOnforms()
                ->textAlign('center'),

            Image::make('Slip')
                ->store(function (Request $request, $model) {
                    $file = $request->file('slip');
                    $extension = $file->getClientOriginalExtension();
                    $filename = "slip_{$model->contract_rent->tenant->first_name}_{$model->contract_rent->tenant->last_name}.{$extension}";
                    $path = $file->storeAs(
                        'images/slip/entrance',
                        $filename,
                        'public'
                    );
                    return [
                        'slip' => $path,
                    ];
                })
                ->disk('public')
                ->showOnpreview()
                ->textAlign('center')
                ->indexWidth(100)
                ->detailWidth(200),

                Text::make('Created At', function () {
                    return optional($this->created_at)->format('Y-m-d H:i:s');
                })
                ->onlyOnDetail()
                ->showOnPreview(),
                
                Text::make('Updated At', function () {
                    return optional($this->updated_at)->format('Y-m-d H:i:s');
                })
                ->onlyOnDetail()
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
            TotalSecurityDeposit::make(),
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
