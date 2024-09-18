@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Total Orders</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Total number of orders: {{ $totalOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Pending Orders</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Total number of pending orders: {{ $pendingOrders }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Drivers Available</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Total number of available drivers: {{ $availableDrivers }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-4">Recent Orders</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Assigned Driver</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>
                        @if ($order->driver)
                            {{ $order->driver->name }}
                        @else
                            <form action="{{ route('admin.orders.assignDriver', $order->id) }}" method="POST">
                                @csrf
                                <select name="driver_id" class="form-control">
                                    <option value="">Select Driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary mt-2">Assign Driver</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
