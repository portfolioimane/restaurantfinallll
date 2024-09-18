<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{


public function store(Request $request)
{
    $cart = Cart::where('user_id', Auth::id())->first();
    if (!$cart) {
        return redirect()->route('cart.index')->with('error', 'Cart not found.');
    }

    // Validate request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
    ]);

    $order = Order::create([
        'user_id' => Auth::id(),
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'address' => $request->input('address'),
        'status' => 'pending',
    ]);

    foreach ($cart->items as $cartItem) {
        $variantDetails = $cartItem->variantDetails; // Assuming $cartItem has a `variantDetails` attribute
        
        // Convert $variantDetails to a collection if it's an array
        $variantDetails = collect($variantDetails);

        // Calculate the total variant price
        $variantTotal = $variantDetails->sum('price');

        $order->items()->create([
            'food_id' => $cartItem->food_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->food->base_price + $variantTotal,
            'variant_details' => json_encode($variantDetails),
        ]);
    }

    // Clear the cart items
    $cart->items()->delete();

    // Emit the orderAdded event

    // Redirect to the order confirmation page with the order details
    return redirect()->route('order.confirmation', ['order' => $order->id])->with('success', 'Order placed successfully!');
}


    public function confirmation(Order $order)
    {
        // Load the order with its items
        $order->load('items.food');

        return view('frontend.orders.confirm', compact('order'));
    }
}
