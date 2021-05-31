<?php

namespace Database\Factories;

use App\Models\ProductDetails;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDetails::class;

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
            'size' => $this->faker->word(),
            'color' => $this->faker->hexColor(),
            'units' => $this->faker->numberBetween(1, 100),
        ];
    }
}
