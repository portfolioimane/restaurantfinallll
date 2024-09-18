@extends('driver.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container">
    <h1 class="my-4">Order Details</h1>

    <p><strong>Order Number:</strong> {{ $order->id }}</p>
    <p><strong>Customer Name:</strong> {{ $order->customer->name }}</p>
    <p><strong>Customer Email:</strong> {{ $order->email }}</p>
    <p><strong>Customer Phone:</strong> {{ $order->phone }}</p>
    <p><strong>Customer Address:</strong> {{ $order->address }}</p>

    <h3>Order Items:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Food</th>
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
