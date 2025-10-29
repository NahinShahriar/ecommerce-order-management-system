<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
            'outlet_id' => null, 
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'outlet_id' => null, 
        ]);

        User::create([
            'name' => 'Outlet Incharge',
            'email' => 'outlet@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'outlet_incharge',
            'outlet_id' => 1,
        ]);
        User::create([
            'name' => 'Outlet Incharge 2',
            'email' => 'outlet2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'outlet_incharge',
            'outlet_id' => 2,
        ]);
    }
}
