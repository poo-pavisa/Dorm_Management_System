<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;


class Booking extends Model
{
    use HasFactory , SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id' , 'room_id' , 'first_name' , 'last_name' ,  'gender',
        'phone' , 'move_in_date', 'note' , 'booking_channel' , 'status',
        'is_sent'
    ];

    protected $casts = [
        'move_in_date' => 'date',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class , 'room_id');
    }

    public function bill_booking()
    {        
        return $this->hasOne(BillBooking::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {

            $datePart = now()->format('dmy'); 
            $lastBooking = static::latest()->withTrashed()->first();
            $lastDatePart = $lastBooking ? substr($lastBooking->booking_ref, 3, 6) : null;

            
            $sequencePart = $lastBooking && $datePart === $lastDatePart ? intval(substr($lastBooking->booking_ref, -3)) + 1 : 1;
            $sequencePartPadded = str_pad($sequencePart, 3, '0', STR_PAD_LEFT); 

            $bookingRef = 'RES' . $datePart . $sequencePartPadded;
            $booking->booking_ref = $bookingRef;
        });
    }

    
    public function getStatusAttribute($value)
    {
        $statusOptions = [
            '0' => 'Pending',
            '1' => 'Payment Received',
            '2' => 'Completed',
            '3' => 'Cancelled',
            
        ];

        return $statusOptions[$value] ?? '';
    }

    
    public function getBookingChannelAttribute($value)
    {
        $bookingchannelOptions = [
            '0' => 'Online',
            '1' => 'Walk-in',     
        ];

        return $bookingchannelOptions[$value] ?? '';
    }

    public function scopePaymentReceived($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 2);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 3);
    }

    
}
