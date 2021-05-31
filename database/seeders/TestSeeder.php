<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Photo;

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
        User::factory()->count(10)->create();

        for($x = 0; $x < 10; $x++){
            $productDetails = ProductDetail::factory()->count(5)->for(Product::factory())->create();

            foreach($productDetails as $productDetail){
                Photo::factory()->count(5)->for($productDetail)->create();
            }
        }
       
    }
}
 