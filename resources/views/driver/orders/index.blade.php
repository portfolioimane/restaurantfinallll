@extends('driver.layouts.app')

@section('title', 'My Orders')

@section('content')
<h1 class="mb-4">My Orders</h1>

<table class="table">
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Phone</th>
            <th>Customer Address</th>
            <th>Food</th>
            <th>Variant Value</th>
            <th>Quantity</th>
            <th>Price per Unit</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ ($order->customer)->name ?? 'N/A' }}</td>
                    <td>{{ $order->email ?? 'N/A' }}</td>
                    <td>{{ $order->phone ?? 'N/A' }}</td>
                    <td>{{ $order->address ?? 'N/A' }}</td>
                    <td>{{ optional($item->food)->name ?? 'N/A' }}</td>
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
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->food->base_price }} MAD</td>
                    <td>
                        @php
                            $variantTotal = $item->variant_details ? collect(json_decode($item->variant_details))->flatMap(function($values) { return collect($values)->pluck('price'); })->sum() : 0;
                            $itemTotal = ($item->food->base_price + $variantTotal) * $item->quantity;
                        @endphp
                        {{ $itemTotal }} MAD
                    </td>
                    <td>
                        
                       <form action="{{ route('driver.orders.updateStatus', $order->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('PUT')
    <select class="form-control form-control-sm" name="status" onchange="this.form.submit()">
        <option value="received" {{ $order->status === 'received' ? 'selected' : '' }}>Received</option>
        <option value="ongoing" {{ $order->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
    </select>
</form>

                    </td>
                    <td>
                        <a href="{{ route('driver.orders.show', $order->id) }}" class="btn btn-info btn-sm">View Details</a>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
@endsection
