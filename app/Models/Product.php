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

    protected $hidden = [
        'image',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $appends = [
        'image_url',
    ];

    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());

        static::creating(function(Product $product){
            $product->slug = Str::slug($product->name);
        });
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
    //$product->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round((1 - (($this->price / $this->compare_price) * 100)) * -1, 1) . '%';
    }
    public $timestamps = false;

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {


            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });

            // $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);

            // $builder->whereRaw('EXISTS IN (SELECT 1 FROM product_id FROM product_tag WHERE tag_id = ? AND product_id = products.id)', [$value]);


            /* $builder->whereHas('tags', function($builder) use ($value) {
                $builder->where('id', $value);
            }); */
        });
    }
}
