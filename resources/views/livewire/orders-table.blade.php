<div>
    <h1 class="mb-4">Orders</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Food</th>
                    <th>Variant Value</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Driver</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @foreach ($order->items as $item)
                        <tr>
                            <td>{{ optional($order->customer)->name ?? 'N/A' }}</td>
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
                            <td>
                                @php
                                    $variantTotal = $item->variant_details ? collect(json_decode($item->variant_details))->flatMap(function($values) { return collect($values)->pluck('price'); })->sum() : 0;
                                    $itemTotal = ($item->food->base_price + $variantTotal) * $item->quantity;
                                @endphp
                                {{ $itemTotal }} MAD
                            </td>
                            <td>
                                <select class="form-control form-control-sm" wire:change="updateStatus({{ $order->id }}, $event.target.value)">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="progress" {{ $order->status === 'progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="received" {{ $order->status === 'received' ? 'selected' : '' }}>Received</option>
                                    <option value="ongoing" {{ $order->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                </select>
                            </td>
                            <td>
                                @if ($order->driver)
                                    {{ $order->driver->name }}
                                @else
                                    <select class="form-control form-control-sm" wire:change="assignDriver({{ $order->id }}, $event.target.value)">
                                        <option value="">Select Driver</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">View Details</a>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
