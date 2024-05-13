<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\UserObserver;
use App\Observers\TenantObserver;
use App\Observers\BillObserver;
use App\Observers\BillBookingObserver;
use App\Observers\BookingObserver;
use App\Observers\CommentObserver;
use App\Observers\ServiceObserver;
use App\Observers\PostObserver;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Bill;
use App\Models\BillBooking;
use App\Models\Booking;
use App\Models\Comment;
use App\Models\ServiceRequest;
use App\Models\Post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->observers();
    }

    private function observers()
    {
        Tenant::observe(TenantObserver::class);
        Booking::observe(BookingObserver::class);
        ServiceRequest::observe(ServiceObserver::class);
        Comment::observe(CommentObserver::class);
        Bill::observe(BillObserver::class);
        BillBooking::observe(BillBookingObserver::class);
        Post::observe(PostObserver::class);
    }
}
