<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the FoodsTableSeeder to seed the foods table
        $this->call(FoodsTableSeeder::class);
        $this->call(UsersTableSeeder::class);       
        $this->call(VariantsTableSeeder::class);
        $this->call(CartsTableSeeder::class);
  
        // You can add other seeders here if needed
        // $this->call(OtherSeeder::class);
    }
}
