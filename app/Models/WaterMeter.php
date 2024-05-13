<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class WaterMeter extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'water_type_id' , 'room_id' ,'start_reading' ,
        'end_reading', 'quantity_consumed'
    ];

    public function water_type()
    {
        return $this->belongsTo(WaterType::class , 'water_type_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class , 'room_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($water) {

            // กำหนดวันเริ่มต้นและสิ้นสุดของเดือนนี้
           $startOfMonth = Carbon::now()->startOfMonth();
           $endOfMonth = Carbon::now()->endOfMonth();  

            // ตรวจสอบว่ามี WaterMeter ในเดือนนี้หรือไม่
           $existingWaterMeter = WaterMeter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
           ->where('room_id', $water->room_id)
           ->exists();

           
           // ถ้ายังไม่มี WaterMeter ในเดือนนี้
           if (!$existingWaterMeter) {
               // ทำการสร้าง WaterMeter
               // ตรวจสอบว่าห้องนี้มี WaterMeter หรือไม่
               $existingWaterMeterInRoom = WaterMeter::where('room_id', $water->room_id)->exists();

               if (!$existingWaterMeterInRoom) {
                   $water->start_reading = $water->room->tenant->contract_rent->start_water_reading;
               } else {
                   $latestWaterMeterInRoom = WaterMeter::where('room_id', $water->room_id)->latest()->first();
                   $water->start_reading = $latestWaterMeterInRoom->end_reading;
               }

               $water->water_type_id = $water->room->floor->dormitory->water_type->id;
               $water->quantity_consumed = $water->end_reading - $water->start_reading;
           } else {
               return false;
           }
       });   

       static::updating(function ($water) {
            $newQuantityConsumed = $water->end_reading - $water->start_reading;
            $oldQuantityConsumed = $water->quantity_consumed;

            if ($newQuantityConsumed !== $oldQuantityConsumed) {
                $water->quantity_consumed = $newQuantityConsumed;
            }        
        });

        static::saving(function ($water) {
            if ($water->end_reading <= $water->start_reading) {
                return false;
            }
        });
    }


}
