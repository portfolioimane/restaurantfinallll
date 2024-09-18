@extends('admin.layouts.app')

@section('title', 'Edit Variant')

@section('content')
<h1 class="mb-4">Edit Variant</h1>

<form action="{{ route('admin.variants.update', $variant) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="food_id">Food</label>
        <select class="form-control" id="food_id" name="food_id" required>
            @foreach ($foods as $food)
                <option value="{{ $food->id }}" {{ $variant->food_id == $food->id ? 'selected' : '' }}>{{ $food->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="type">Variant Type</label>
        <input type="text" class="form-control" id="type" name="type" value="{{ $variant->type }}" required>
    </div>

    <div class="variant-values">
        <h4>Variant Values</h4>
        @foreach ($variant->variantValues as $index => $value)
        <div class="form-group row variant-value">
            <div class="col-md-6">
                <label for="value">Value</label>
                <input type="text" class="form-control" name="values[{{ $index }}][value]" value="{{ $value->value }}" required>
            </div>
            <div class="col-md-6">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="values[{{ $index }}][price]" value="{{ $value->price }}" step="0.01">
            </div>
        </div>
        @endforeach
    </div>

    <div class="form-row">
        <div class="col">
            <button type="button" id="add-variant-value" class="btn btn-secondary">Add Variant Value</button>
        </div>
        <div class="col text-right">
            <button type="submit" class="btn btn-primary ml-2">Save</button> <!-- Added ml-2 for margin-left -->
        </div>
    </div>
</form>

<script>
document.getElementById('add-variant-value').addEventListener('click', function() {
    var container = document.querySelector('.variant-values');
    var index = container.querySelectorAll('.variant-value').length;
    var newVariantValue = `
        <div class="form-group row variant-value">
            <div class="col-md-6">
                <label for="value">Value</label>
                <input type="text" class="form-control" name="values[${index}][value]" required>
            </div>
            <div class="col-md-6">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="values[${index}][price]" step="0.01">
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newVariantValue);
});
</script>
@endsection
