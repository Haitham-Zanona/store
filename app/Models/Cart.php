<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'cookie_id',
        'user_id',
        'product_id' ,
        'quantity',
        'options',
    ];

    /**
     * Events (observers)
     * creating, created, updating, updated, saving, saved
     * deleting, deleted, restoring, restored, retrieved(select)
     */

     protected static function booted(){
        //creating event
        static::observe(CartObserver::class);

       /*  static::creating(function (Cart $cart){
            $cart->id = Str::uuid();
        }); */
     }

     public function user(){
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
     }

     public function product(){
        return $this->belongsTo(Product::class);
     }

}
