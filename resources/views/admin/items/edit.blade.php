@extends('layouts.frontend.app')

@section('title', 'Edit Item')

@section('content')
<div class="container mt-5" style="background-color: Beige; border-radius: 15px; padding: 30px;">
    <h3 class="fw-bold mb-4">Edit Item</h3>

    <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_id" class="form-label">Select Product</label>
            <select name="product_id" id="product_id" class="form-select" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Item Name</label>
            <input type="text" name="name" id="name" value="{{ $item->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (per month)</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ $item->price }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="form-control">{{ $item->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="active" {{ $item->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $item->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-success" style="background-color: PeachPuff; border:none; color:black;">Update Item</button>
        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
