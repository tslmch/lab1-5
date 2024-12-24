<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Orange',
            'cost' => 500, // стоимость в копейках
            'amount' => 27,
        ]);

        Product::create([
            'name' => 'Banana',
            'cost' => 120,
            'amount' => 17,
        ]);

        Product::create([
            'name' => 'Bread',
            'cost' => 70,
            'amount' => 0,
        ]);
    }
}
