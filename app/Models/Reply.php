<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'content' , 'service_request_id' , 'admin_id'
    ];

    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($reply) {
            if ( !$reply->admin_id ) {
                $reply->admin_id = Auth::id();
            }
        });
    }
}
