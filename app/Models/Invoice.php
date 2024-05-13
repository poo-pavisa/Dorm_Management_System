<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'tenant_id' , 'room_rate' , 'water_rate' ,
        'electricity_rate' ,'total_amount' ,'month', 'status',
        'invoice_ref', 'is_published',
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class , 'tenant_id');
    }

    public function additional_rates()
    {
        return $this->hasMany(AdditionalRate::class);
    }

    public function contract_rent()
    {
        return $this->hasOne(ContractRent::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $datePart = now()->format('dmy'); 
            $latestInvoice = static::latest()->first(); 
            $lastDatePart = $latestInvoice ? substr($latestInvoice->invoice_ref, 3, 6) : null; 
            $sequencePart = $latestInvoice && $datePart === $lastDatePart ? intval(substr($latestInvoice->invoice_ref, -3)) + 1 : 1; 
            $sequencePartPadded = str_pad($sequencePart, 3, '0', STR_PAD_LEFT);
            
            /* Calculate Invoice total - Start */

            /* Calculate Invoice total - End */

            $invoiceRef = 'INV' . $datePart . $sequencePartPadded;
            $invoice->invoice_ref = $invoiceRef;
        });

        
    }


    public function getStatusAttribute($value)
    {
        $statusOptions = [
            '0' => 'Awaiting Payment',
            '1' => 'Pending Review',
            '2' => 'Paid',
            '3' => 'Outstanding', 
        ];

        return $statusOptions[$value] ?? '';
    }

    public function scopeAwaiting($query)
    {
        return $query->where('status', 0);
    }

    public function scopePending($query)
    {
        return $query->where('status', 1);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 2);
    }

    public function scopeOutstanding($query)
    {
        return $query->where('status', 3);
    }
}
