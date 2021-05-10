<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'quantity' => $this->faker->numberBetween(1, 200),
            'address' => $this->faker->address(),
        ];
    }
}
