@extends('layouts.frontend.front')

@section('content')
<div class="container py-5">
  <div class="card shadow-lg border-0 rounded-4 text-center" style="background-color: PeachPuff;">
    <div class="card-body p-5">
      <img src="{{ asset('assets/images/success.png') }}" alt="Success" style="width: 90px;">
      <h3 class="fw-bold mt-4 text-success">Payment Successful!</h3>
      <p class="mt-3 text-dark">
        Thank you, <strong>{{ $customer->name ?? 'Customer' }}</strong>!<br>
        Your subscription has been activated successfully.
      </p>
      <a href="{{ route('home') }}" class="btn btn-primary mt-4 rounded-pill px-4 py-2 shadow-sm">
        Back to Home
      </a>
    </div>
  </div>
</div>

<style>
.card { background: linear-gradient(145deg, PeachPuff, Cornsilk); }
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
