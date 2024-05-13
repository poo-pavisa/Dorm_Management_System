<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Carbon\Carbon;
use Timothyasp\Badge\Badge;
use App\Nova\Actions\StartProgress;
use App\Nova\Actions\CompleteRequest;
use App\Nova\Metrics\CompletedRequests;
use App\Nova\Metrics\InProgessRequests;
use App\Nova\Metrics\PendingRequests;

class ServiceRequest extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ServiceRequest>
     */
    public static $model = \App\Models\ServiceRequest::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'subject';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'subject', 'room.room_no'
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
            
            Text::make('Request Ref', 'request_ref')
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->textAlign('center'),
        
            Text::make('Subject')
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->textAlign('center'),

            Textarea::make('Detail')
                ->required()
                ->showOnPreview()
                ->textAlign('center'),

            DateTime::make('Due Date' , 'due_date')
                ->required()
                ->showOnPreview()
                ->textAlign('center'),

            Badge::make('Status' , 'status')
                ->sortable()
                ->showOnPreview()
                ->showOnDetail()
                ->options([
                    'Pending' => 'Pending',
                    'In Progress' => 'In Progress',
                    'Completed' => 'Completed',
                ])
                ->colors([
                    'Pending' => '#fac240',
                    'In Progress' => '#4691D3',
                    'Completed' => '#235D3A',
                ]),

            Image::make('Image', 'image')
                ->store(function (Request $request, $model) {
                    $file = $request->file('image');
                    $request = $model->request_ref;
                    $currentDate = Carbon::now()->format('Ymd_His');
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'request' . $request . '_' . $currentDate . '.' . $extension; 
                    $path = $file->storeAs(
                        'images/request',
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
            
            Text::make('Created At', function () {
                return $this->created_at->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),

            Text::make('Updated At', function () {
                return $this->updated_at->format('Y-m-d H:i:s');
                })->onlyOnDetail()
                ->showOnPreview(),
            
            HasMany::make('Replies'),

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
            CompletedRequests::make(),
            InProgessRequests::make(),
            PendingRequests::make(),
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
            StartProgress::make()->showOnTableRow()->canSee(function ($request) {
                return $this->status !== 'In Progress' && $this->status !== 'Completed';
            }),

            CompleteRequest::make()->showOnTableRow()->canSee(function ($request) {
                return $this->status !== 'Pending' && $this->status !== 'Completed';
            }),
        ];
    }
}
