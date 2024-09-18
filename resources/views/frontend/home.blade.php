@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    <div class="text-center">
        <h1 class="display-4">Welcome to Our Restaurant</h1>
        <p class="lead">Discover our delicious menu and order your favorites online.</p>
        <a href="{{ route('foods.index') }}" class="btn btn-primary btn-lg">View Menu</a>
    </div>
@endsection
