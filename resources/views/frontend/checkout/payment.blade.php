@extends('layouts.frontend.front')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm rounded" style="background-color: #FFF8DC;">
                <div class="card-body text-center">

                    {{-- ===== Page Header ===== --}}
                    <h4 class="mb-3 text-primary">Payment Page</h4>
                    <p class="mb-1"><strong>Customer Name:</strong> {{ $customer->name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $customer->email }}</p>
                    <p class="mb-1"><strong>Duration:</strong> {{ $duration }} month(s)</p>
                    <p class="mb-3"><strong>Total Amount:</strong> ${{ number_format($total, 2) }}</p>

                    {{-- ===== Payment Form ===== --}}
                    <form action="{{ route('checkout.payment.process') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                        {{-- ===== Payment Methods ===== --}}
                        <h5 class="text-secondary mb-3">Select Payment Method</h5>
                        <div class="d-flex flex-wrap justify-content-center mb-4">
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="card" value="card" checked>
                                <label class="form-check-label" for="card">
                                    <i class="fas fa-credit-card"></i> Card
                                </label>
                            </div>
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bkash" value="bkash">
                                <label class="form-check-label" for="bkash">
                                    <img src="{{ asset('assets/images/bkash.png') }}" alt="bKash" width="25"> bKash
                                </label>
                            </div>
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="nagad" value="nagad">
                                <label class="form-check-label" for="nagad">
                                    <img src="{{ asset('assets/images/nagad.png') }}" alt="Nagad" width="25"> Nagad
                                </label>
                            </div>
                            <div class="form-check mx-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    <i class="fab fa-paypal"></i> PayPal
                                </label>
                            </div>
                        </div>

                        {{-- ===== Card Fields (only show when card is selected) ===== --}}
                        <div id="cardFields" class="text-start mb-4">
                            <div class="mb-2">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="expiry" class="form-label">Expiry</label>
                                    <input type="text" id="expiry" class="form-control" placeholder="MM/YY">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" id="cvv" class="form-control" placeholder="123">
                                </div>
                            </div>
                        </div>

                        {{-- ===== Demo Status (for simulation) ===== --}}
                        <h6 class="text-muted mb-2">Payment Status (Demo)</h6>
                        <div class="d-flex justify-content-center mb-3">
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="radio" name="payment_status" id="success" value="success" checked>
                                <label class="form-check-label" for="success">Success</label>
                            </div>
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="radio" name="payment_status" id="failure" value="failure">
                                <label class="form-check-label" for="failure">Failure</label>
                            </div>
                        </div>

                        {{-- ===== Submit Button ===== --}}
                        <button type="submit" class="btn btn-primary w-100">Submit Payment</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Custom JS to toggle payment fields ===== --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const methodRadios = document.querySelectorAll('input[name="payment_method"]');
    const cardFields = document.getElementById('cardFields');

    methodRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'card') {
                cardFields.style.display = 'block';
            } else {
                cardFields.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
@endsection
