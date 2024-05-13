<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalRate extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
       'invoice_id' , 'additional_rate' , 'description',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($additionalRate) {

            $invoice = $additionalRate->invoice;
            if($invoice){
                $invoice->update(['total_amount' => $invoice->total_amount + $additionalRate->additional_rate]);
            }
        });


        static::updated(function ($additionalRate) {
            $invoice = $additionalRate->invoice;
            if($invoice){
                $invoice->update(['total_amount' => $invoice->total_amount + $additionalRate->additional_rate]);
            }
        });

        static::deleted(function ($additionalRate) {
            $invoice = $additionalRate->invoice;
            if($invoice){
                $invoice->update(['total_amount' => $invoice->total_amount - $additionalRate->additional_rate]);
            }
        });

    }
}
