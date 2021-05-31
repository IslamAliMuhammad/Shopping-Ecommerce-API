<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductDetails;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::factory()->count(10)->create();
        $products = Product::factory()->count(20)->create();
        $productDetails = ProductDetails::factory()->count(5)->create();

        dd($productDetails);
    }
}
