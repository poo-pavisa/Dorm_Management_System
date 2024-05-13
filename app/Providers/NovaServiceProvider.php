<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Menu\MenuItem;
use App\Nova\Dashboards\Main;
use App\Nova\Booking;
use Llaski\NovaScheduledJobs\Tool as NovaScheduledJobsTool;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withoutGlobalSearch();
        $this->getFooterContent();
        $this->getCustomMenu();

    }


    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */

     
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaScheduledJobsTool,
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function getFooterContent(): void 
    {
        Nova::footer(function ($request){
            return Blade::render('nova/footer');
        });
    }

    private function getCustomMenu()
    {
        Nova::mainMenu(function(Request $request){
            return [
                MenuSection::dashboard(Main::class)
                ->icon('chart-square-bar')
                ->withBadge('New', 'success'),

                MenuSection::make('Announcements',[
                    MenuItem::make('Posts', '/resources/posts'),
                    MenuItem::make('Comments' , '/resources/comments'),
                ])->icon('speakerphone')->collapsable(),

                MenuSection::make('Billing',[
                    MenuItem::make('Invoices', '/resources/invoices'),
                    MenuItem::make('Additional Rates', '/resources/additional-rates'),
                ])->icon('credit-card')->collapsable(),

                MenuSection::resource(Booking::class)->icon('calendar'),

                MenuSection::make('Dormitory',[
                    MenuItem::make('Dormitory', '/resources/dormitories'),
                    MenuItem::make('Bank Account', '/resources/bank-accounts'),
                    MenuItem::make('Electricity Type', '/resources/electricity-types'),
                    MenuItem::make('Floor', '/resources/floors'),
                    MenuItem::make('Water Type', '/resources/water-types'),
                ])->icon('office-building')->collapsable(),
         
                MenuSection::make('Payments',[
                    MenuItem::make('Bills', '/resources/bills'),
                    MenuItem::make('Bill Bookings', '/resources/bill-bookings'),
                ])->icon('cash')->collapsable(),

                MenuSection::make('Room',[
                    MenuItem::make('All Rooms' , '/resources/rooms'),
                    MenuItem::make('Assets', '/resources/assets'),
                    MenuItem::make('Room Galleries' , '/resources/room-galleries'),
                ])->collapsable(),

                MenuSection::make('Service Requests',[
                    MenuItem::make('Requests', '/resources/service-requests'),
                    MenuItem::make('Replies' , '/resources/replies'),
                ])->icon('inbox-in')->collapsable(),

                MenuSection::make('Tenants',[
                    MenuItem::make('Contract Rents', '/resources/contract-rents'),
                    MenuItem::make('Entrance Fees' , '/resources/entrance-fees'),
                ])->icon('user-circle')->collapsable(),
                
                
                MenuSection::make('Utilities Metering',[
                        MenuItem::make('Electricity Meter', '/resources/electricity-meters'),
                        MenuItem::make('Water Meter', '/resources/water-meters'),
                ])->icon('lightning-bolt')->collapsable(),
         

                MenuSection::make('User Management',[
                    MenuItem::make('Admins', '/resources/admins'),
                    MenuItem::make('Users', '/resources/users'),
                    MenuItem::make('Tenants', '/resources/tenants'),
                ])->icon('user-group')->collapsable(),


            ];

        });
    }
}
