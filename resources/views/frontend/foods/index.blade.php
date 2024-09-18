@extends('frontend.layouts.app')

@section('title', 'Menu')

@section('content')
    <h1 class="mb-4">Menu</h1>
    <div class="row">
        @foreach ($foods as $food)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/food-placeholder.jpg') }}" class="card-img-top" alt="{{ $food->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $food->name }}</h5>
                        <p class="card-text">{{ $food->description }}</p>
                        <p class="card-text"><strong>Price:</strong> {{ $food->base_price }} MAD</p>
                        <a href="{{ route('foods.show', $food) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
