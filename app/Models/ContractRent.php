<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class ContractRent extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'tenant_id' , 'bill_booking_id' ,
        'contract_start_date' , 'contract_duration' , 'contract_end_date' ,
        'security_deposit' , 'boooking_deduction' , 'booking_payment_date' , 
        'booking_receipt_ref' , 'start_water_reading' , 'start_electricity_reading' ,
        'note',
    ];

    protected $casts = [
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'booking_payment_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class , 'tenant_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class , 'invoice_id');
    }

    public function billBooking()
    {
        return $this->belongsTo(BillBooking::class , 'bill_booking_id');
    }

    public function entranceFee()
    {
        return $this->hasOne(EntranceFee::class , 'contract_rent_id','id');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            $start_date = new Carbon($contract->contract_start_date);
            $contract_duration = $contract->contract_duration;

            $end_date = $start_date->copy()->addMonths($contract_duration);

            $contract->contract_end_date = $end_date;

            $contract->security_deposit = $contract->tenant->room->security_deposit;

            if ($contract->bill_booking_id) {

                $contract->booking_deduction = $contract->billBooking->deposit;

                $contract->booking_payment_date = Carbon::createFromFormat('Y-m-d H:i:s', $contract->billBooking->created_at)->format('Y-m-d');
                
                $contract->booking_receipt_ref = $contract->billBooking->booking_receipt_ref;
            }
            else
            {
                $contract->booking_deduction = 0;
                $contract->booking_payment_date = null;
                $contract->booking_receipt_ref = null;
            }

        });

        static::created(function ($contract) {

                $entranceFee = new EntranceFee();
                $entranceFee->contract_rent_id = $contract->id;
                $entranceFee->sum_payable = $contract->security_deposit - $contract->booking_deduction;
                $entranceFee->save();

        });
        
        


        static::updating(function ($contract) {

                $start_date = new Carbon($contract->contract_start_date);
                $contract_duration = $contract->contract_duration;

                $end_date = $start_date->copy()->addMonths($contract_duration);

                $contract->contract_end_date = $end_date;

                $contract->security_deposit = $contract->tenant->room->security_deposit;

                if ($contract->bill_booking_id) {

                    $contract->booking_deduction = $contract->billBooking->deposit;
                    $contract->booking_payment_date = Carbon::createFromFormat('Y-m-d H:i:s', $contract->billBooking->created_at)->format('Y-m-d');
                    $contract->booking_receipt_ref = $contract->billBooking->booking_receipt_ref;
                }
                else
                {
                    $contract->booking_deduction = 0;
                    $contract->booking_payment_date = null;
                    $contract->booking_receipt_ref = null;
                }
            });
        }

    
}
