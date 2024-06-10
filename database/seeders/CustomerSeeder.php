<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()
            ->hasInvoices(20)
            ->count(25)
            ->create();
        Customer::factory()
            ->hasInvoices(5)
            ->count(25)
            ->create();
        Customer::factory()
            ->hasInvoices(15)
            ->count(25)
            ->create();
        Customer::factory()
            ->hasInvoices(25)
            ->count(25)
            ->create();
    }
}
