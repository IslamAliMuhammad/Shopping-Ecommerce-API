<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->words(4, true),
            'category_id' => $this->faker->numberBetween(1, 4),
            'gender_id' => $this->faker->numberBetween(1, 4),
            'name' => $this->faker->realTextBetween(5, 50),
            'description' => $this->faker->realTextBetween(50, 100),
            'price' => $this->faker->randomFloat(2, 10, 100000),
            'photo_path' => $this->faker->imageUrl(640, 480, 'product', true),
        ];
    }
}
