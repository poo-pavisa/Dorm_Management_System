<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Notifications\CompletedBooking;
use Illuminate\Notifications\Notifiable;


class BillBooking extends Model
{
    use HasFactory , SoftDeletes, Notifiable;

    protected $fillable = [
        'booking_id' , 'deposit' , 'slip' , 'booking_receipt_ref', 'is_approved'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($billBooking) {
            $booking = $billBooking->booking;
            if ($booking) {
                $billBooking->deposit = $booking->room->deposit;
            }

            // กำหนดค่า booking_receipt_ref
            $datePart = now()->format('dmy'); 
            $lastBill = static::latest()->first(); 
            $lastDatePart = $lastBill ? substr($lastBill->booking_receipt_ref, 3, 6) : null; 
            $sequencePart = $lastBill && $datePart === $lastDatePart ? intval(substr($lastBill->booking_receipt_ref, -3)) + 1 : 1;
            $sequencePartPadded = str_pad($sequencePart, 3, '0', STR_PAD_LEFT); 
            $bookingReceiptRef = 'RCP' . $datePart . $sequencePartPadded;
            $billBooking->booking_receipt_ref = $bookingReceiptRef;

            if ($billBooking->is_approved == 1) {
                $booking = $billBooking->booking;
                if ($booking) {
                    $user = $booking->user;
                    $user->notify(new CompletedBooking([
                        'hi' => "Hey, {$user->name}"]));

                    $booking->update(['status' => 2]);
                    $booking->update(['is_sent' => 1]);
                    
                    $room = $booking->room;
                    if ($room && $room->is_available) {
                        $room->is_available = 0;
                        $room->save();
                    }
                }
            }

        });

        static::updated(function ($billBooking) {
            if ($billBooking->is_approved == 1) {
                $booking = $billBooking->booking;
                if ($booking) {
                    $user = $booking->user;
                    $user->notify(new CompletedBooking([
                        'hi' => "Hey, {$user->name}"]));

                    $booking->update(['status' => 2]);
                    $booking->update(['is_sent' => 1]);
                }
            }
        });
    }


    public function booking()
    {        
        return $this->belongsTo(Booking::class , 'booking_id');
    }

    public function contract_rent()
    {
        return $this->hasOne(ContractRent::class, 'bill_booking_id' , 'id');
    }

    public function scopeApprovedBooking($query)
    {
        return $query->where('is_approved', 1);
    }

    public function scopeUnApprovedBooking($query)
    {
        return $query->where('is_approved', 0);
    }


}
