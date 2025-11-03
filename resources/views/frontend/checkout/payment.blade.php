@extends('layouts.frontend.front')

@section('content')
<div class="container py-5">
  <div class="payment-wrapper shadow-lg rounded-4 overflow-hidden">
    <div class="row g-0">

      {{-- ===== LEFT SIDE: SUMMARY ===== --}}
      <div class="col-lg-5 d-flex flex-column justify-content-between text-dark p-4" style="background: linear-gradient(160deg, PeachPuff, Cornsilk);">
        <div>
          <h4 class="fw-bold mb-3 text-center text-primary">Payment Summary</h4>
          <div class="summary-box p-3 rounded-3 mb-3" style="background-color: rgba(255,255,255,0.6);">
            <p class="mb-1"><strong>Customer:</strong> {{ $customer->name }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $customer->email }}</p>
            @if(isset($product))
              <p class="mb-1"><strong>Product:</strong> {{ $product->name }}</p>
              <p class="mb-1"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            @endif
            <p class="mb-1"><strong>Duration:</strong> {{ $duration }} month(s)</p>
            <hr>
            <p class="mb-0 fs-5 fw-bold text-success">Total: ${{ number_format($total, 2) }}</p>
          </div>
        </div>
        <div class="text-center mt-3">
          <img src="{{ asset('assets/images/payment-illustration.png') }}" alt="Payment Illustration" class="img-fluid" style="max-height:180px;">
        </div>
      </div>

      {{-- ===== RIGHT SIDE: SSLCommerz PAYMENT ONLY ===== --}}
      <div class="col-lg-7 p-5 text-center" style="background-color: Lavender;">
        <img src="{{ asset('assets/images/sslcommerz-logo.png') }}" alt="SSLCommerz" style="max-height:55px;">
        <h4 class="fw-semibold mt-3 text-primary">Secure Payment via SSLCommerz</h4>
        <p class="text-muted small mb-4">
          You will be redirected to SSLCommerz to complete your secure payment using your preferred wallet or card.
        </p>

        <form action="{{ route('checkout.payment.process') }}" method="POST">
          @csrf
          <input type="hidden" name="customer_id" value="{{ $customer->id }}">
          <input type="hidden" name="main_method" value="ssl">

          <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-pill shadow">
            <i class="fas fa-lock me-2"></i>Pay Now with SSLCommerz
          </button>
        </form>

        <div class="mt-4">
          <small class="text-muted">
            <i class="fas fa-shield-alt me-1"></i>SSLCommerz ensures encrypted and secure transaction.
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.payment-wrapper {
  background-color: Beige;
  border-radius: 15px;
}
.form-control {
  border-radius: 10px;
  border-color: #ddd;
}
.summary-box {
  box-shadow: inset 0 0 6px rgba(0,0,0,0.05);
}
.btn-primary {
  background-color: #9370DB;
  border-color: #9370DB;
}
.btn-primary:hover {
  background-color: #8258C0;
  border-color: #8258C0;
}
</style>
@endsection
