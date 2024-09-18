<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class PlaceOrder extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $cart;
    public $cartTotal;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
    ];

    public function mount()
    {
        $this->cart = Cart::where('user_id', Auth::id())->first();

        if (!$this->cart) {
            return redirect()->route('cart.index')->with('error', 'Cart not found.');
        }

        $this->calculateCartTotal();
    }

    public function calculateCartTotal()
    {
        $this->cartTotal = $this->cart->items->sum(function ($item) {
            $variantTotal = collect($item->variantDetails)->flatMap(function ($values) {
                return collect($values)->pluck('price');
            })->sum();
            return ($item->food->base_price + $variantTotal) * $item->quantity;
        });
    }

    public function placeOrder()
    {
        $this->validate();

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => 'pending',
        ]);

        foreach ($this->cart->items as $cartItem) {
            $variantDetails = $cartItem->variantDetails;

            $variantDetails = collect($variantDetails);

            $variantTotal = $variantDetails->sum('price');

            $order->items()->create([
                'food_id' => $cartItem->food_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->food->base_price + $variantTotal,
                'variant_details' => json_encode($variantDetails),
            ]);
        }

        $this->cart->items()->delete();

        session()->flash('success', 'Order placed successfully!');
        return redirect()->route('order.confirmation', ['order' => $order->id]);
    }

    public function render()
    {
        return view('livewire.place-order');
    }
}
