<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        return view('admin.foods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'base_price' => 'required|numeric',
        ]);

        Food::create($request->all());

        return redirect()->route('admin.foods.index')->with('success', 'Food item created successfully.');
    }

    public function edit(Food $food)
    {
        return view('admin.foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'base_price' => 'required|numeric',
        ]);

        $food->update($request->all());

        return redirect()->route('admin.foods.index')->with('success', 'Food item updated successfully.');
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('admin.foods.index')->with('success', 'Food item deleted successfully.');
    }
}
