<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Variant;

class VariantsTableSeeder extends Seeder
{
    public function run()
    {
        Variant::create([
            'food_id' => 1, // Pizza
            'type' => 'sauce',
        ]);

        Variant::create([
            'food_id' => 2, // Burger
            'type' => 'drink',
        ]);
    }
}
