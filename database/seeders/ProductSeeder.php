<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics
            ['name'=>'Laptop','description'=>'High performance laptop','price'=>65000,'stock'=>10,'image'=>'/images/laptop.jpg'],
            ['name'=>'Smartphone','description'=>'Latest smartphone','price'=>25000,'stock'=>20,'image'=>'/images/smartphone.jpg'],
            ['name'=>'Headphones','description'=>'Noise-cancelling headphones','price'=>5000,'stock'=>15,'image'=>'/images/headphones.jpg'],
            ['name'=>'Smartwatch','description'=>'Fitness smartwatch','price'=>5000,'stock'=>25,'image'=>'/images/smartwatch.jpg'],

            // Grocery
            ['name'=>'Rice (5kg)','description'=>'Premium basmati rice','price'=>600,'stock'=>50,'image'=>'/images/rice.jpg'],
            ['name'=>'Cooking Oil (1L)','description'=>'Refined sunflower oil','price'=>250,'stock'=>40,'image'=>'/images/cooking_oil.jpg'],
            ['name'=>'Sugar (2kg)','description'=>'White crystal sugar','price'=>180,'stock'=>35,'image'=>'/images/sugar.jpg'],
            ['name'=>'Tea (500g)','description'=>'Premium green tea','price'=>450,'stock'=>20,'image'=>'/images/tea.jpg'],

            // Fashion
            ['name'=>'Men T-Shirt','description'=>'Cotton casual T-shirt','price'=>700,'stock'=>30,'image'=>'/images/men_tshirt.jpg'],
            ['name'=>'Women Dress','description'=>'Summer floral dress','price'=>1500,'stock'=>25,'image'=>'/images/women_dress.jpg'],
            ['name'=>'Sneakers','description'=>'Comfortable running shoes','price'=>2500,'stock'=>20,'image'=>'/images/sneakers.jpg'],
            ['name'=>'Wrist Watch','description'=>'Analog stylish watch','price'=>3500,'stock'=>15,'image'=>'/images/wrist_watch.jpg'],

            // Home Appliances
            ['name'=>'Microwave','description'=>'700W Microwave oven','price'=>8000,'stock'=>10,'image'=>'/images/microwave.jpg'],
            ['name'=>'Blender','description'=>'Electric food blender','price'=>4000,'stock'=>12,'image'=>'/images/blender.jpg'],
            ['name'=>'Ceiling Fan','description'=>'120cm ceiling fan','price'=>3500,'stock'=>15,'image'=>'/images/ceiling_fan.jpg'],
            ['name'=>'LED Bulb','description'=>'10W energy saving LED','price'=>300,'stock'=>50,'image'=>'/images/led_bulb.jpg'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
