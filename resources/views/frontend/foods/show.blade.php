@extends('frontend.layouts.app')

@section('title', $food->name)

@section('content')
<div class="container">
    <h1 class="my-4">{{ $food->name }}</h1>
    <p class="lead">{{ $food->description }}</p>
    <p><strong>Price:</strong> {{ $food->base_price }} MAD</p>

    <form action="{{ route('cart.store') }}" method="POST">
        @csrf
        <input type="hidden" name="food_id" value="{{ $food->id }}">

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1">
        </div>

        @foreach ($food->variants as $variant)
            <div class="form-group">
                <label class="font-weight-bold">{{ ucfirst($variant->type) }}</label>
                <div class="card">
                    <div class="card-body">
                        @foreach ($variant->variantValues as $value)
                            <div class="form-check">
                                <input type="checkbox" name="variant_values[{{ $variant->id }}][]" value="{{ $value->id }}" class="form-check-input" id="variant_value_{{ $value->id }}">
                                <label class="form-check-label" for="variant_value_{{ $value->id }}">
                                    {{ $value->value }} (+{{ $value->price }} MAD)
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-4">Add to Cart</button>
    </form>
</div>
@endsection
