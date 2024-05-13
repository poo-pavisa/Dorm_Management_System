<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class Bill extends Model
{
    use HasFactory , SoftDeletes, Notifiable;

    protected $fillable = [
        'invoice_id' , 'amount' , 'slip' , 'invoice_receipt_ref', 'is_approved'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class , 'invoice_id');
    }
   
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($bill) {

            $datePart = now()->format('dmy');
            $lastInvoice = static::latest()->first();
            $lastDatePart = $lastInvoice ? substr($lastInvoice->invoice_receipt_ref, 3, 6) : null;
            $sequencePart = $lastInvoice && $datePart === $lastDatePart ? intval(substr($lastInvoice->invoice_receipt_ref, -3)) + 1 : 1;
            $sequencePartPadded = str_pad($sequencePart, 3, '0', STR_PAD_LEFT); 

            if ($bill->invoice) {
                $bill->amount = $bill->invoice->total_amount;
            }

            $invoiceReceiptRef = 'RCP' . $datePart . $sequencePartPadded;
            $bill->invoice_receipt_ref = $invoiceReceiptRef;
    
        });

        static::created(function ($bill) {
            if ($bill->is_approved == 1) 
            { 
                $bill->invoice->status = 2;
                $bill->invoice->save(); 
            }
        });


        static::updated(function ($bill) {
            if ($bill->is_approved == 1) {
                $invoice = $bill->invoice;
                if ($invoice) {
                    $invoice->update(['status' => 2]);
                }
            }
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    public function scopeUnApproved($query)
    {
        return $query->where('is_approved', 0);
    }



}
