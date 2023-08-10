<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Category;
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

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store(){
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    protected $fillable= [
        'name',
        'description',
        'image',
        'store_id',
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
