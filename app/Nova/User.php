<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\BelongsToMany;
use KABBOUCHI\NovaImpersonate\Impersonate;
use Themsaid\CashierTool\CashierResourceTool;
use Coreproc\NovaAuditingUserFields\CreatedBy;
use Coreproc\NovaAuditingUserFields\UpdatedBy;
use DigitalCloud\NovaResourceNotes\Fields\Notes;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\Models\\User';

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
        'id', 'first_name', 'last_name', 'email',
    ];

     /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Account';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Gravatar::make(),

            Text::make('First Name', 'first_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name', 'last_name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Select::make( __('Review'),  'review')
                ->sortable()
                ->options([
                    'successful' => 'successful',
                    'pending' => 'pending',
                    'not_started' => 'not started',
                ])->displayUsingLabels(),

            DateTime::make(__('Verfication Date'),  'profile_verified_at'),

            CreatedBy::make('Created By'),

            UpdatedBy::make('Updated By')->onlyOnDetail(),

            Notes::make('Notes','notes')->onlyOnDetail(),
            
            HasOne::make('Profile'),
            HasMany::make('Jobs'),
            HasMany::make('Reviews'),
            HasOne::make('Account'),
            BelongsToMany::make('Plan'),

            MorphToMany::make('Roles', 'roles', \Vyuldashev\NovaPermission\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Vyuldashev\NovaPermission\Permission::class),

            Impersonate::make($this)->withMeta([
			    'redirect_to' => '/settings'
            ]),
            
            CashierResourceTool::make()->onlyOnDetail()

     

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new \Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel,
        ];
    }
}
