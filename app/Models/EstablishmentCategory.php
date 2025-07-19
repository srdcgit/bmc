<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstablishmentCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','icon'];
    
    public function establishments()
    {
        return $this->hasMany(Establishment::class,'establishment_category_id');
    }
}
