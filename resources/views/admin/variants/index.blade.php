@extends('admin.layouts.app')

@section('title', 'Variants')

@section('content')
<h1 class="mb-4">Variants</h1>

<!-- Create Variant Button -->
<a href="{{ route('admin.variants.create') }}" class="btn btn-success mb-3">Create Variant</a>

<table class="table">
    <thead>
        <tr>
            <th>Food</th>
            <th>Type</th>
            <th>Values</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($variants as $variant)
        <tr>
            <td>{{ $variant->food->name }}</td>
            <td>{{ $variant->type }}</td>
            <td>
                <ul>
                    @foreach ($variant->variantValues as $value)
                    <li>{{ $value->value }} (Price: {{ $value->price ?? 'N/A' }})</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <a href="{{ route('admin.variants.edit', $variant) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.variants.destroy', $variant) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
