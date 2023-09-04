<?php

namespace App\Models;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id' ,
        'status' ,
        'payment_method' ,
        'payment_status' ,
    ];

    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function user(){
        return $this->belongsTo(User::class)
            ->withDefault([
                'name'=>'Guest Customer',
            ]);
    }
    public function products(){
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot([
                'product_name', 'price', 'quantity', 'options',
            ]);
    }

    public function addresses() {
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAddresses() {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'billing');
        // return $this->addresses()->where('type', '=', 'billing');
    }
    public function shippingAddresses() {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')
            ->where('type', '=', 'shipping');
    }

    protected static function booted() {
        static::creating(function(Order $order){
            //  20220001, 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }
    public static function getNextOrderNumber() {
        // SELECT MAX(number FROM orders)
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
