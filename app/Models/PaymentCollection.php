<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCollection extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id','amount',
        'order_id',
        'transcation_id',
        'payment_mode',
    ];
    public function payment()
    {
        return $this->belongsTo(Payment::class,'payment_id');
    }
}
