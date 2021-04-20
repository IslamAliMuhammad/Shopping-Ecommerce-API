<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\ProductFactory;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = Product::factory()->count(10)->create();
    }
}
