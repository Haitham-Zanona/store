<?php

namespace App\Models;

use App\Concerns\HasRoles;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends User
{
    use HasFactory,
        Notifiable,
        HasApiTokens,
        HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'super_admin',
        'status',
        'phone_number',
    ];

}
