<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cam extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'establishment_id',
    ];
    
    public function establishment()
    {
        return $this->belongsTo(Establishment::class,'establishment_id');
    }
}
