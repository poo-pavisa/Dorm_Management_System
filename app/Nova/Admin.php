<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasOne;
use Illuminate\Support\Str;

class Admin extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Admin>
     */
    public static $model = \App\Models\Admin::class;

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
        'name', 'email'
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
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:admins,email,NULL,id,deleted_at,NULL')
                ->updateRules('unique:admins,email,{{resourceId}},id,deleted_at,NULL'),
                
            Text::make('Phone'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
                    
            Image::make('Profile', 'profile_photo_path')
            ->store(function (Request $request, $model) {
                $file = $request->file('profile_photo_path');
                $profileName = $model->name;
                $extension = $file->getClientOriginalExtension();
                $filename = 'admin_' . $profileName . '.' . $extension;
                $path = $file->storeAs(
                    'images/profile/admin',
                    $filename,
                    'public'
                );
                return [
                    'profile_photo_path' => $path,
                ];
            })
            ->disk('public')
            ->showOnPreview()
            ->textAlign('center')
            ->indexWidth(50)
            ->detailWidth(150),

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
