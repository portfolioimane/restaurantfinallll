@extends('admin.layouts.app')

@section('title', 'Edit Food')

@section('content')
<h1 class="mb-4">Edit Food</h1>

<form action="{{ route('admin.foods.update', $food->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $food->name }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $food->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="base_price">Base Price</label>
        <input type="number" class="form-control" id="base_price" name="base_price" step="0.01" value="{{ $food->base_price }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
