<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreetVendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'uu_id',
        'name',
        'area',
        'photo',
        'address',
        'mobilenumber'
    ];
}
