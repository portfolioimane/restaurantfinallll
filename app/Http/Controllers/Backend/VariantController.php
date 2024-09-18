<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use App\Models\Food;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index()
    {
        // Load variants with their associated food and variant values
        $variants = Variant::with(['food', 'variantValues'])->get();
        return view('admin.variants.index', compact('variants'));
    }

    public function create()
    {
        $foods = Food::all();
        return view('admin.variants.create', compact('foods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'type' => 'required|string',
            'values' => 'required|array',
            'values.*.value' => 'required|string',
            'values.*.price' => 'nullable|numeric',
        ]);

        // Create the variant
        $variant = Variant::create([
            'food_id' => $request->food_id,
            'type' => $request->type,
        ]);

        // Create associated variant values
        foreach ($request->values as $value) {
            $variant->variantValues()->create($value);
        }

        return redirect()->route('admin.variants.index')->with('success', 'Variant and values created successfully.');
    }

    public function edit(Variant $variant)
    {
        $foods = Food::all();
        // Load variant with its associated variant values
        $variant->load('variantValues');
        return view('admin.variants.edit', compact('variant', 'foods'));
    }

    public function update(Request $request, Variant $variant)
    {
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'type' => 'required|string',
            'values' => 'required|array',
            'values.*.value' => 'required|string',
            'values.*.price' => 'nullable|numeric',
        ]);

        // Update the variant
        $variant->update([
            'food_id' => $request->food_id,
            'type' => $request->type,
        ]);

        // Delete old variant values
        $variant->variantValues()->delete();

        // Create new variant values
        foreach ($request->values as $value) {
            $variant->variantValues()->create($value);
        }

        return redirect()->route('admin.variants.index')->with('success', 'Variant and values updated successfully.');
    }

    public function destroy(Variant $variant)
    {
        // Delete associated variant values
        $variant->variantValues()->delete();

        // Delete the variant
        $variant->delete();

        return redirect()->route('admin.variants.index')->with('success', 'Variant and values deleted successfully.');
    }
}
