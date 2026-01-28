<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Price::create([
            'name' => 'Monthly',
            'price' => 100,
            'status' => 'active',
        ]);
        Price::create([
            'name' => 'Daily',
            'price' => 4,
            'status' => 'active',
        ]);
    }
}
