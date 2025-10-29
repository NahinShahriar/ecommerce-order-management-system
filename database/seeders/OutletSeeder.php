<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $outlets = [
            ['name' => 'Dhaka Outlet', 'address' => 'Dhaka, Bangladesh', 'phone' => '01712345678'],
            ['name' => 'Chittagong Outlet', 'address' => 'Chittagong, Bangladesh', 'phone' => '01812345678'],
            ['name' => 'Khulna Outlet', 'address' => 'Khulna, Bangladesh', 'phone' => '01912345678'],
        ];

        foreach ($outlets as $outlet) {
            Outlet::create($outlet);
        }
        
    }
}
