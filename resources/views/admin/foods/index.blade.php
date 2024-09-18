@extends('admin.layouts.app')

@section('title', 'Foods')

@section('content')
<h1 class="mb-4">Foods</h1>
<a href="{{ route('admin.foods.create') }}" class="btn btn-primary mb-3">Add New Food</a>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Base Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($foods as $food)
            <tr>
                <td>{{ $food->name }}</td>
                <td>{{ $food->description }}</td>
                <td>${{ $food->base_price }}</td>
                <td>
                    <a href="{{ route('admin.foods.edit', $food->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
