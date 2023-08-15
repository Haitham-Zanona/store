<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable =[
        'name','slug'
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
        //IF you committed to laravel default models, migration and functions name you don't need to define every parameters
    }
}
