<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'store_id' => $this->faker->randomElement(['CN001', 'CN002', 'CN003', 'CN004', 'CN005']),
            'billed_date' => $this->faker->dateTimeThisYear(),
            'total_cost' => $this->faker->numberBetween(10, 100),
        ];
    }
}
