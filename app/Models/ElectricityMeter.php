<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ElectricityMeter extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'electricity_type_id' , 'room_id' ,'start_reading' ,
        'end_reading', 'quantity_consumed'
    ];

    public function electricity_type()
    {
        return $this->belongsTo(ElectricityType::class , 'electricity_type_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class , 'room_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($electricity) {

           $startOfMonth = Carbon::now()->startOfMonth();
           $endOfMonth = Carbon::now()->endOfMonth();  

           $existingElectricityMeter = ElectricityMeter::whereBetween('created_at', [$startOfMonth, $endOfMonth])
           ->where('room_id', $electricity->room_id)
           ->exists();

           
           if (!$existingElectricityMeter) {
               $existingElectricityMeterInRoom = ElectricityMeter::where('room_id', $electricity->room_id)->exists();

               if (!$existingElectricityMeterInRoom) {
                   $electricity->start_reading = $electricity->room->tenant->contract_rent->start_electricity_reading;
               } else {
                   $latestElectricityMeterInRoom = ElectricityMeter::where('room_id', $electricity->room_id)->latest()->first();
                   $electricity->start_reading = $latestElectricityMeterInRoom->end_reading;
               }

               $electricity->electricity_type_id = $electricity->room->floor->dormitory->electricity_type->id;
               $electricity->quantity_consumed = $electricity->end_reading - $electricity->start_reading;
           } else {
               return false;
           }
       });   

        static::updating(function ($electricity) {
            $newQuantityConsumed = $electricity->end_reading - $electricity->start_reading;
            $oldQuantityConsumed = $electricity->quantity_consumed;

        // อัปเดตปริมาณที่ใช้ไฟเฉพาะเมื่อมีการเปลี่ยนแปลงค่า end_reading หรือ start_reading
            if ($newQuantityConsumed !== $oldQuantityConsumed) {
                $electricity->quantity_consumed = $newQuantityConsumed;
            }        
        });

        static::saving(function ($electricity) {
            if ($electricity->end_reading <= $electricity->start_reading) {
                return false;
            }
        });
    }
}
