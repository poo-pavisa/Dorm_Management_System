<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Asset extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'room_id' , 'name' , 'damage_price' ,
        'status', 'is_published',  'image',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class , 'room_id');
    }

    public function scopeNormal($query)
    {
        return $query->where('status', 1);
    }

    public function scopeDamaged($query)
    {
        return $query->where('status', 0);
    }

}
