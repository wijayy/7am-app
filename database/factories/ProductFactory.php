<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $image = mt_rand(1, 10) < 2 ? 'product/product1.jpg' : 'product/product2.jpg';

        return [
            'name' => fake()->sentence(3, false),
            'sku' => Product::skuNumberGenerator(),
            'price' => mt_rand(1, 25),
            'description' => fake()->paragraph(),
            'category_id' => Category::factory(),
            'moq' => 1,
            'image' => $image,
        ];
    }
}
