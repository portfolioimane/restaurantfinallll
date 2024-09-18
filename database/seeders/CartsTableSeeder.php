<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;

class CartsTableSeeder extends Seeder
{
    public function run()
    {
        Cart::create([
            'user_id' => 2, // Customer User ID
        ]);
    }
}
