@extends('layouts.frontend.app')

@section('title', 'Edit Product')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0" style="background-color: Lavender;">
                <div class="card-header text-center fw-bold" style="background-color: PeachPuff;">
                    ✏️ Edit Product
                </div>

                <div class="card-body" style="background-color: Cornsilk;">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Product Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                   class="form-control rounded-pill" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control rounded-4">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select name="status" id="status" class="form-select rounded-pill" required>
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary rounded-pill px-4">⬅ Back</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: PeachPuff; border: none;">
                                💾 Update Product
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center" style="background-color: Beige;">
                    <small>SubPilot Admin Panel</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
