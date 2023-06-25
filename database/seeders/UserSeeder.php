<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // we use the model to insert
        User::create([
            'name' => 'Haitham Mohamed',
            'email' => 'hytham3024@gmail.com',
           'password' => Hash::make('password'),
           'phone_number' => '970591234567',
        ]);
        // You can duplicate the user
        ///////////////////////////////
        // DB is a query builder, we use it to insert data
        DB::table('users')->insert([
            'name' => 'Haitham Zanona',
            'email' => 'hytham2499@gmail.com',
           'password' => Hash::make('password'),
           'phone_number' => '970591687567',
        ]);
    }
}
