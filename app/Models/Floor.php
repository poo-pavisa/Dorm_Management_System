<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dorm_id' , 'floor_no'
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class, 'dorm_id');
    }
    

    public function rooms()
    {
        return $this->hasMany(Room::class,);
    }

    
    
}
