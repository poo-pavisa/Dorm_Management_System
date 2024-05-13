<?php

namespace App\Observers;

use App\Models\Comment;
use Laravel\Nova\Notifications\NovaNotification;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        $this->getNovaNotification($comment, 'New Comment In : ' , 'success');
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        $this->getNovaNotification($comment, 'Updated Comment In: ' , 'info');
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        $this->getNovaNotification($comment, 'Deleted Comment In: ' , 'error');
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        $this->getNovaNotification($comment, 'Restored Comment In: ' , 'success');
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        $this->getNovaNotification($comment, 'Forece Deleted Comment In: ' , 'error');
    }

    private function getNovaNotification($comment, $message, $type): void
    {
        foreach(Comment::all() as $c) {
            $c->notify(NovaNotification::make()
                    ->message($message . '' . $comment->post->title)
                    ->icon('annotation')
                    ->type($type));
        }
    }
}
