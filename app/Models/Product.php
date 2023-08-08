<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    protected $fillable= [
        'name',
        'description',
        'image',
        'parent_id',
        'category_id',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status',
        'slug',
    ];

    public $timestamps = false;
}
