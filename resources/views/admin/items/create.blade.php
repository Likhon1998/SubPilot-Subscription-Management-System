@extends('layouts.frontend.app')

@section('title', 'Add New Item')

@section('content')
<div class="container mt-5" style="background-color: Beige; border-radius: 15px; padding: 30px;">
    <h3 class="fw-bold mb-4">Add New Item</h3>

    <form action="{{ route('admin.items.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Select Product</label>
            <select name="product_id" id="product_id" class="form-select" required>
                <option value="">-- Choose Product --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Item Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter item name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (per month)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="0.00" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Item details"></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <button class="btn btn-success" style="background-color: PeachPuff; border:none; color:black;">Save Item</button>
        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
