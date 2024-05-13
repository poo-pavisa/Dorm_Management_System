<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'content', 'post_id' , 'user_id' , 'admin_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class , 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($comment) {
            if (Auth::user() instanceof \App\Models\Admin) {
                $comment->admin_id = Auth::id();
            } elseif (Auth::user() instanceof \App\Models\User) {
                $comment->admin_id = null;
            }
        });
    }
}
