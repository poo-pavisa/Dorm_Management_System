<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntranceFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contract_rent_id' , 'sum_payable', 'slip',
    ];

    public function contract_rent()
    {
        return $this->belongsTo(ContractRent::class, 'contract_rent_id');
    }
}
