<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;


class BankAccount extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\BankAccount>
     */
    public static $model = \App\Models\BankAccount::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'account_no' ;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'account_name' , 'account_no' , 'bank_name'
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
            BelongsTo::make('Dormitory')
                ->sortable()
                ->showOnPreview()
                ->withoutTrashed()
                ->displayUsing(function ($dorm) {
                    return $dorm->name;
                })
                ->textAlign('center'),

            Text::make('Account Name' , 'account_name')
                ->showOnPreview()
                ->rules('required','max:255')
                ->sortable()
                ->textAlign('center'),

            Number::make('Account No.' , 'account_no')
                ->showOnPreview()
                ->rules('required', 'numeric')
                ->placeholder('Account Number')
                ->sortable()
                ->textAlign('center'),

            
            Select::make('Bank Name', 'bank_name')
                ->options([
                    'PP' => 'PromptPay',
                    'BBL' => 'Bangkok Bank',
                    'KBANK' => 'Kasikorn Bank',
                    'KTB' => 'Krungthai Bank',
                    'SCB' => 'Siam Commercial Bank',
                    'BAY' => 'Bank of Ayudhya',
                    'TMB' => 'Thai Military Bank',
                    'TBANK' => 'Thanachart Bank',
                    'KK' => 'KIATNAKIN Bank',
                    'TISCO' => 'TISCO Bank',
                    'CIMBT' => 'CIMB Thai Bank',
                    'LH' => 'Land and Houses Bank',
                    'UOB' => 'United Overseas Bank',
                    'BAAC' => 'BANK FOR AGRICULTURE AND AGRICULTURAL COOPERATIVES',
                    'ICBC' => 'Industrial and Commercial Bank of China Limited',
                    'GSB' => 'Government Savings Bank',
                ])
                ->rules('required')
                ->sortable()
                ->textAlign('center')
                ->showOnPreview(),

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
