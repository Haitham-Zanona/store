<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     //Related Model
            'product_tag',  //Pivot table name
            'product_id',   //FK i pivot table for the current model
            'tag_id',       //FK i pivot table for the related model
            'id',           //PK current Model
            'id'            //PK related Model
        );
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    //Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return 'https://www.ehabra.com/storage/images/documents/_res/wrh/def_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' .$this->image);
    }

    public function getSalePercentAttribute(){
        if (!$this->compare_price){
            return 0;
        }
        return round((1 - (($this->price /$this->compare_price)*100)) *-1 ,1).'%';
    }
    public $timestamps = false;
}
