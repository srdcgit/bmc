<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'amount',
        'order_id',
        'transcation_id',
        'payment_method',
        'payment_mode',
        'payment_date',
        'interest',
        'receipt_number'
    ];
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
