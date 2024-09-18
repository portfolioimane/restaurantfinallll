<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display the cart with associated food and variant details
public function index()
{
    $cart = Cart::where('user_id', Auth::id())
        ->with('items.food') // Eager load food relationship
        ->first();

    // Ensure cart is not null to prevent errors
    if (!$cart) {
        $cart = new Cart();
    }

    // Adding variant details to each cart item
    $cart->items->each(function ($item) {
        $item->load('food'); // Load food relationship
        // Accessor to get the variant details
        $item->getVariantDetailsAttribute();
    });

    // Debugging output

    
    return view('frontend.cart.index', compact('cart'));
}


    // Add or update an item in the cart
    public function store(Request $request)
    {
        $request->validate([
            'food_id' => 'required|exists:food,id',
            'quantity' => 'required|integer|min:1',
            'variant_values' => 'nullable|array',
            'variant_values.*' => 'array',
            'variant_values.*.*' => 'exists:variant_values,id',
        ]);

        $food = Food::findOrFail($request->food_id);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $variantValues = $request->input('variant_values', []);


        $cartItem = $cart->items()->updateOrCreate(
            [
                'food_id' => $food->id,
                'variant_values' => json_encode($variantValues),
            ],
            ['quantity' => $request->quantity]
        );

        return redirect()->route('cart.index')->with('success', 'Item added to cart!');
    }

    // Update the quantity of a cart item
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart item updated!');
    }

    // Remove an item from the cart
    public function destroy($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Cart item removed!');
    }
}
