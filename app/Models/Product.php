<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'composition',
        'brand',
        'price',
        'price_promotion',
        'active',
        'weight',
        'height',
        'width',
        'length',
    ];

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
}
