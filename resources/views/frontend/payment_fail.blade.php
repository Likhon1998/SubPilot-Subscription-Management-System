@extends('layouts.frontend.app')

@section('content')
<div class="container py-5">
  <div class="card shadow-lg border-0 rounded-4 text-center" style="background-color: Beige;">
    <div class="card-body p-5">
      <img src="{{ asset('assets/images/fail.png') }}" alt="Failed" style="width: 90px;">
      <h3 class="fw-bold mt-4 text-danger">Payment Failed!</h3>
      <p class="mt-3 text-muted">
        Oops! Something went wrong during the transaction.<br>
        Please try again later or contact support.
      </p>
      <a href="{{ route('checkout.payment', $customer->id ?? 0) }}" class="btn btn-primary mt-4 rounded-pill px-4 py-2 shadow-sm">
        Try Again
      </a>
    </div>
  </div>
</div>

<style>
.card { background: linear-gradient(145deg, Beige, Cornsilk); }
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
