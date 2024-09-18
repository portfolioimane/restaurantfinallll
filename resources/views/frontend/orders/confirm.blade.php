@extends('frontend.layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container">
    <h1 class="my-4">Order Confirmation</h1>

    <p>Thank you for your order! Your order number is <strong>{{ $order->id }}</strong>.</p>

    <h3>Customer Details:</h3>
    <p><strong>Name:</strong> {{ $order->name ?? 'N/A' }}</p>
    <p><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ $order->phone ?? 'N/A' }}</p>
    <p><strong>Address:</strong> {{ $order->address ?? 'N/A' }}</p>

    <h3>Order Details:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Variant</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->food->name }}</td>
                    <td>
                        @if ($item->variant_details)
                            @php
                                $variantDetails = json_decode($item->variant_details);
                            @endphp
                            @foreach ($variantDetails as $type => $values)
                                {{ ucfirst($type) }}:
                                @foreach ($values as $value)
                                    {{ $value->value }} (+{{ $value->price }} MAD)<br>
                                @endforeach
                            @endforeach
                        @else
                            No variant selected
                        @endif
                    </td>
                    <td>{{ $item->food->base_price }} MAD</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        @php
                            $itemTotal = ($item->food->base_price + ($item->variant_details ? collect(json_decode($item->variant_details))->flatMap(function($values) { return collect($values)->pluck('price'); })->sum() : 0)) * $item->quantity;
                        @endphp
                        {{ $itemTotal }} MAD
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        @php
            $cartTotal = $order->items->sum(function ($item) {
                $variantTotal = $item->variant_details ? collect(json_decode($item->variant_details))->flatMap(function($values) { return collect($values)->pluck('price'); })->sum() : 0;
                return ($item->food->base_price + $variantTotal) * $item->quantity;
            });
        @endphp
        <h4>Total: {{ $cartTotal }} MAD</h4>
    </div>
</div>
@endsection
