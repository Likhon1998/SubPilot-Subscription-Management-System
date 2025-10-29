@extends('layouts.frontend.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Checkout Customers & Subscriptions</h3>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Checkout Completed</th>
                <th>Subscriptions</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        @if($customer->checkout_completed)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-warning">No</span>
                        @endif
                    </td>
                    <td>
                        @if($customer->subscriptions->count())
                            <ul class="list-unstyled mb-0">
                                @foreach($customer->subscriptions as $sub)
                                    <li>
                                        <strong>{{ $sub->item->name ?? 'Item deleted' }}</strong>
                                        ({{ $sub->start_date->format('Y-m-d') }} → {{ $sub->end_date->format('Y-m-d') }})
                                        - <span class="badge bg-info">{{ ucfirst($sub->status) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">No subscriptions</span>
                        @endif
                    </td>
                    <td>{{ $customer->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
