<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Dormitory extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name' , 'address' , 'phone' , 'email' , 'bill_date' , 'payment_due_date',
    ];

    public function floors()
    {
        return $this->hasMany(Floor::class, 'dorm_id' , 'id');
    }

    public function bank_accounts()
    {
        return $this->hasMany(BankAccount::class,'dorm_id' , 'id');
    }

    public function electricity_type()
    {
        return $this->hasOne(ElectricityType::class,'dorm_id' , 'id' );
    }

    public function water_type()
    {
        return $this->hasOne(WaterType::class,'dorm_id' , 'id');
    }

    
}
