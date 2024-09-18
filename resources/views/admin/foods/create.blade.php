@extends('admin.layouts.app')

@section('title', 'Add Food')

@section('content')
<h1 class="mb-4">Add New Food</h1>

<form action="{{ route('admin.foods.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="base_price">Base Price</label>
        <input type="number" class="form-control" id="base_price" name="base_price" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection
