<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Post extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'title', 'content','image','status_comment' , 'admin_id'
    ];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if ( !$post->admin_id ) {
                $post->admin_id = Auth::id();
            }
        });
    }
    
    

}

