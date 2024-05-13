<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'dorm_id' , 'account_name' , 'account_no' , 'bank_name',
    ];

    public function dormitory()
    {
        return $this-> belongsTo(Dormitory::class, 'dorm_id');
    }

    public function getBankNameAttribute($value)
    {
        switch ($value) {
            case 'PP':
                return 'PromptPay';
            case 'BBL':
                return 'Bangkok Bank';
            case 'KBANK':
                return 'Kasikorn Bank';
            case 'KTB':
                return 'Krungthai Bank';
            case 'SCB':
                return 'Siam Commercial Bank';
            case 'BAY':
                return 'Bank of Ayudhya';
            case 'TMB':
                return 'Thai Military Bank';
            case 'TBANK':
                return 'Thanachart Bank';
            case 'KK':
                return 'KIATNAKIN Bank';
            case 'TISCO':
                return 'TISCO Bank';
            case 'CIMBT':
                return 'CIMB Thai Bank';
            case 'LH':
                return 'Land and Houses Bank ';
            case 'UOB':
                return 'United Overseas Bank';
            case 'BAAC':
                return 'BANK FOR AGRICULTURE AND AGRICULTURAL COOPERATIVES';
            case 'ICBC':
                return 'Industrial and Commercial Bank of China Limited';
            case 'GSB':
                return 'Government Savings Bank';
            default:
                return $value; 
        }
    }
    
}
