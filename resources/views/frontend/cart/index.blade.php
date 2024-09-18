@extends('frontend.layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container">
    <h1 class="my-4">Your Cart</h1>

    @if ($cart && $cart->items->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Variant</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->items as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>
                            @if (is_array($item->variantDetails) && count($item->variantDetails) > 0)
                                @foreach ($item->variantDetails as $type => $values)
                                    {{ ucfirst($type) }}:
                                    @foreach ($values as $value)
                                        {{ $value['value'] }} (+{{ $value['price'] }} MAD)<br>
                                    @endforeach
                                @endforeach
                            @else
                                No variant selected
                            @endif
                        </td>
                        <td>{{ $item->food->base_price }} MAD</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control" min="1">
                                <button type="submit" class="btn btn-sm btn-primary mt-2">Update</button>
                            </form>
                        </td>
                        <td>
                            @php
                                $variantTotal = collect($item->variantDetails)->flatMap(function ($values) {
                                    return collect($values)->pluck('price');
                                })->sum();
                                $itemTotal = ($item->food->base_price * $item->quantity) + $variantTotal;
                            @endphp
                            {{ $itemTotal }} MAD
                        </td>
                        <td>
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            @php
                $cartTotal = $cart->items->sum(function ($item) {
                    $variantTotal = collect($item->variantDetails)->flatMap(function ($values) {
                        return collect($values)->pluck('price');
                    })->sum();
                    return ($item->food->base_price + $variantTotal) * $item->quantity;
                });
            @endphp
            <h4>Total: {{ $cartTotal }} MAD</h4>
        </div>

        <!-- Order Form -->
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success mt-4">Place Order</button>
        </form>

    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
