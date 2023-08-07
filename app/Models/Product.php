<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
