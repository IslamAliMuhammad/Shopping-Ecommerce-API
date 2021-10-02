<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Photo;
use App\Models\Order;

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

        $users = $this->createUsers(5);

        foreach($users as $user){
            $user->ProductColors()->attach($this->createProductColors(2), ['quantity' => 10]);
        }

        $this->attachColorSize([1, 2, 3, 4, 5]);

        $this->createOrders(5, 2);
    }

    /**
     * Create dummy data for users table.
     *
     * @param int $usersNum Number of users to create
     * @return App\Models\User
     */
    public function createUsers($usersNum){
        return User::factory()->count($usersNum)->create();
    }

    /**
     * Create dummy data for associated tables product_details, products, and photos.
     * 
     * @param int $ProductColorsNum Number of product_detais to create
     * @param int $photosNum Number of photo for product_details to create
     * @return App\Models\ProductColor
     */
    public function createProductColors($ProductColorsNum, $photosNum = 5) {

        $ProductColors = ProductColor::factory()->count($ProductColorsNum)->for(Product::factory())->create();

        foreach($ProductColors as $ProductColor){
            Photo::factory()->count($photosNum)->for($ProductColor)->create();
        }

        return $ProductColors;
    }

    /**
     * Create dummy data for associated tables users, orders, order_item, product_details.
     * Create order to each user with provided number of product_details.
     * 
     * @param int $usersNum Number of users to create
     * @param int $ProductColorsNum Number of product_details per order to create
     * @return void
     */
    public function createOrders($usersNum, $ProductColorsNum){
        $users = $this->createUsers($usersNum);

        foreach($users as $user){
            $order = Order::factory()->for($user)->create();

            $ProductColors = $this->createProductColors($ProductColorsNum);

           $order->ProductColors()->attach($ProductColors, ['quantity' => 5]);
        }

    }

    public function attachColorSize($sizeIds) {
        $productColors = ProductColor::all();

        foreach($productColors as $productColor){
            $productColor->sizes()->attach($sizeIds, ['units' => rand(5, 100)]);
        }
    }


}
