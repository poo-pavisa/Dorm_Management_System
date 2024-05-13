<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class ServiceRequest extends Model
{
    use HasFactory , SoftDeletes, Notifiable;

    protected $fillable = [
        'room_id' , 'request_ref', 'subject' , 'detail' , 'due_date' , 
        'status' , 'image'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'service_request_id' ,'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($request) {

            $datePart = now()->format('dmy');
            $lastRequest = static::latest()->withTrashed()->first(); 
            $lastDatePart = $lastRequest ? substr($lastRequest->request_ref, 3, 6) : null;
            $sequencePart = $lastRequest && $datePart === $lastDatePart ? intval(substr($lastRequest->request_ref, -3)) + 1 : 1; // หาลำดับที่ล่าสุดและเพิ่มขึ้น 1 หากวันที่ปัจจุบันเหมือนกับบิลล่าสุด
            $sequencePartPadded = str_pad($sequencePart, 3, '0', STR_PAD_LEFT); // แปลงลำดับให้อยู่ในรูปแบบ 3 หลัก

            $requestRef = 'REQ' . $datePart . $sequencePartPadded;
            $request->request_ref = $requestRef;
        });
    }


}
