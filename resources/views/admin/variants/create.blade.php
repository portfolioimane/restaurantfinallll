@extends('admin.layouts.app')

@section('title', 'Create Variant')

@section('content')
<h1 class="mb-4">Create Variant</h1>

<form action="{{ route('admin.variants.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="food_id">Food</label>
        <select class="form-control" id="food_id" name="food_id" required>
            @foreach ($foods as $food)
                <option value="{{ $food->id }}">{{ $food->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="type">Variant Type</label>
        <input type="text" class="form-control" id="type" name="type" required>
    </div>

    <div class="variant-values">
        <h4>Variant Values</h4>
        <div class="form-group row variant-value">
            <div class="col-md-6">
                <label for="value">Value</label>
                <input type="text" class="form-control" name="values[0][value]" required>
            </div>
            <div class="col-md-6">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="values[0][price]" step="0.01">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <button type="button" id="add-variant-value" class="btn btn-secondary">Add Variant Value</button>
        </div>
        <div class="col text-right">
            <button type="submit" class="btn btn-primary">Save</button>
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
