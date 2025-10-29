@extends('layouts.frontend.front')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            <div class="checkout-card p-4 shadow-sm rounded" style="background-color: #FFF8DC;">
                <h4 class="mb-3 text-center text-primary">Checkout — {{ $product->name }}</h4>
                <p class="text-muted small mb-4 text-center">{{ $product->description }}</p>

                {{-- Checkout Summary --}}
                <div class="summary-box mb-3">
                    <strong>Selected Items:</strong> 
                    @php
                        $items = json_decode(request('items', '[]'), true);
                        $duration = request('duration', 1);
                        $total = request('total', 0);
                    @endphp
                    <span class="badge bg-info text-dark">{{ count($items) }}</span><br>
                    <strong>Duration:</strong> {{ $duration }} month(s)<br>
                    <strong>Total:</strong> ৳{{ number_format($total, 2) }}
                </div>

                {{-- Customer Info Form --}}
                <form method="POST" action="{{ route('checkout.submit') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="items" value="{{ json_encode($items) }}">
                    <input type="hidden" name="duration" value="{{ $duration }}">
                    <input type="hidden" name="total" value="{{ $total }}">

                    <div class="mb-3">
                        <label for="name" class="form-label small">Full Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small">Email Address</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label small">Phone Number</label>
                        <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Continue → Verify OTP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
