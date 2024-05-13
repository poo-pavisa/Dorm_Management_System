<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'room_id' ,'user_id' , 'first_name' , 'last_name' , 'gender' , 'phone' ,
        'identification_no' , 'date_of_birth' , 'nationality' , 'address' ,
        'image_id_card' , 'image_profile',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contract_rent()
    {
        return $this->hasOne(ContractRent::class);
    }
    
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($tenant) {
            $room = $tenant->room;
            $room->is_available = 1;
            $room->save();          
        });

        
        static::restored(function ($tenant) {
            $room = $tenant->room;
            $room->is_available = 0;
            $room->save();
        });
        
    }

    

}
