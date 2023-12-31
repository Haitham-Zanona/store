<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;


    // That's default value at model class it's just a reference for me

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_=at';

    protected $connection = 'mysql';

    protected $table = 'stores';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    public function products(){
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}
