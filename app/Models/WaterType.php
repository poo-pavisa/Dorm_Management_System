<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaterType extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'dorm_id' , 'type' , 'price_per_unit'
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class, 'dorm_id');
    }

    public function water_meters()
    {
        return $this->hasMany(WaterMeter::class);
    }
    
}
