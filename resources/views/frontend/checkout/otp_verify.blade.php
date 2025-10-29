@extends('layouts.frontend.front')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="otp-card p-4 shadow-sm rounded" style="background-color: #E6E6FA;">
                
                <h4 class="mb-3 text-center text-primary">Verify Your Email</h4>
                <p class="text-muted text-center small">
                    An OTP has been sent to <strong>{{ $customer->email }}</strong><br>
                    Please enter it below to continue.
                </p>

                {{-- ✅ OTP Verification Form --}}
                <form method="POST" action="{{ route('checkout.otp.verify') }}">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                    <div class="mb-3">
                        <label for="otp" class="form-label small">Enter OTP Code</label>
                        <input 
                            type="text" 
                            class="form-control form-control-sm text-center @error('otp') is-invalid @enderror" 
                            id="otp" 
                            name="otp" 
                            placeholder="6-digit code" 
                            maxlength="6" 
                            required
                        >
                        @error('otp')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Verify & Proceed →</button>
                    </div>
                </form>

                {{-- Resend Section --}}
                <div class="text-center mt-3">
                    <small class="text-muted">Didn’t get the code?</small><br>
                    <a href="#" class="text-primary small" id="resend-otp">Resend OTP</a>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Simple JS alert for Resend OTP --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const resendBtn = document.getElementById('resend-otp');
    resendBtn.addEventListener('click', function(e) {
        e.preventDefault();
        alert('OTP has been resent to your email! (Feature coming soon)');
      
    });
});
</script>
@endsection
