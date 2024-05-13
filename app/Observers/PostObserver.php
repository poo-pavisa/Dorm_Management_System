<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $users = User::where('role', 'Tenant')->get();
        
        foreach ($users as $user) {
            $user->notify(new NewPostNotification([
                'hi' => "Hey, {$user->name}"
            ]));
        }
    }
}
