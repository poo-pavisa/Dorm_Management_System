<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'floor_id' , 'room_no' , 'daily_rate' , 'monthly_rate',
        'deposit' , 'detail' , 'image' , 'is_available'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    public function room_galleries()
    {
        return $this->hasMany(RoomGallery::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'room_id' ,'id');
    }

    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public function electricity_meters()
    {
        return $this->hasMany(ElectricityMeter::class);
    }

    public function water_meters()
    {
        return $this->hasMany(WaterMeter::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
    
}
