<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Food;

class FoodsTableSeeder extends Seeder
{
    public function run()
    {
        Food::create([
            'name' => 'Pizza',
            'description' => 'Delicious cheese pizza.',
            'base_price' => 50.00,
        ]);

        Food::create([
            'name' => 'Burger',
            'description' => 'Juicy beef burger.',
            'base_price' => 30.00,
        ]);
    }
}
