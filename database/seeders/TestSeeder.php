<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductDetail;
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
            $user->productDetails()->attach($this->createProductDetails(2), ['quantity' => 10]);
        }

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
     * @param int $productDetailsNum Number of product_detais to create
     * @param int $photosNum Number of photo for product_details to create
     * @return App\Models\ProductDetail
     */
    public function createProductDetails($productDetailsNum, $photosNum = 5) {

        $productDetails = ProductDetail::factory()->count($productDetailsNum)->for(Product::factory())->create();

        foreach($productDetails as $productDetail){
            Photo::factory()->count($photosNum)->for($productDetail)->create();
        }

        return $productDetails;
    }

    /**
     * Create dummy data for associated tables users, orders, order_item, product_details.
     * Create order to each user with provided number of product_details.
     * 
     * @param int $usersNum Number of users to create
     * @param int $productDetailsNum Number of product_details per order to create
     * @return void
     */
    public function createOrders($usersNum, $productDetailsNum){
        $users = $this->createUsers($usersNum);

        foreach($users as $user){
            $order = Order::factory()->for($user)->create();

            $productDetails = $this->createProductDetails($productDetailsNum);

           $order->productDetails()->attach($productDetails, ['quantity' => 5]);
        }

    }


}
