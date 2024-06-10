<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        $stars = $this->faker->numberBetween(0, 200);
        $type = ($stars >= 100) ? "Gold" : "Green";

        return [
            'fullname' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'birthday'=> $this->faker->dateTimeBetween('1980-01-01', '2004-12-31'),
            'star_points' => $stars,
            'type' => $type,
        ];
    }
}
