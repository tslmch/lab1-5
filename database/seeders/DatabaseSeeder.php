<?php

namespace Database\Seeders;
use Database\Seeders\UserSeeder;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder; 

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $this->call(ProductSeeder::class);
    }
}


