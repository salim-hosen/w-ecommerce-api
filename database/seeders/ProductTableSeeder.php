<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                "name" => "New T-shirt with Charming Color",
                "description" => "T-shirt is best for Warm weather",
                "price" => 10.5,
                "qty" => 100,
                "image" => "product.jpg",
                "slug" => Str::slug("New T-shirt with Charming Color")
            ]
        ];

        \App\Models\Product::insert($products);
    }
}
