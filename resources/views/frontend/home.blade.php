@extends('layouts.frontend.front')

@section('content')
<div class="container py-4">
    <div class="page-header mb-4">
        <h4 class="mb-1">Our Products</h4>
        <p class="text-muted small mb-0">Choose the perfect subscription plan for your needs</p>
    </div>

    @if($products && $products->count() > 0)
        <div class="row g-3">
            @foreach($products as $product)
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-3">
                        <!-- Product Name & Description -->
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <p class="text-muted small mb-2">{{ $product->description }}</p>

                        <!-- Items List -->
                        @if($product->items && $product->items->count() > 0)
                        <ul class="list-group list-group-flush mb-2">
                            @foreach($product->items as $item)
                            <li class="list-group-item p-2 d-flex justify-content-between align-items-center">
                                <span>{{ $item->name }}</span>
                                <span class="text-primary">৳{{ number_format($item->price, 2) }}/mo</span>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p class="text-muted small mb-2">No items available.</p>
                        @endif

                        <!-- Subscribe Button -->
                        <a href="{{ route('product.details', $product->id) }}" class="btn btn-sm btn-primary w-100">
                            Subscribe
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <p class="text-muted">No products available at the moment.</p>
        </div>
    @endif
</div>
@endsection
