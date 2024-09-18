<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Variant;
use App\Models\VariantValue;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('variants.variantValues')->get();
        return view('frontend.foods.index', compact('foods'));
    }

    public function show(Food $food)
    {
        $food->load('variants.variantValues');
        return view('frontend.foods.show', compact('food'));
    }
}
