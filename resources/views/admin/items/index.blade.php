@extends('layouts.frontend.app')

@section('title', 'Manage Items')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Items List</h2>
        <a href="{{ route('admin.items.create') }}" class="btn btn-primary" style="background-color: PeachPuff; border:none; color:black;">+ Add Item</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center shadow-sm" style="background-color: Cornsilk;">
        <thead style="background-color: Lavender;">
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Name</th>
                <th>Price (per month)</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->product->name ?? 'N/A' }}</td>
                <td>{{ $item->name }}</td>
                <td>${{ $item->price }}</td>
                <td>
                    <span class="badge {{ $item->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-sm btn-warning text-dark">Edit</a>
                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger text-light">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-muted">No items found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
