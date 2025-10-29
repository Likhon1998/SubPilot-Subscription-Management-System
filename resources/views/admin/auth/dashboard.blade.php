@extends('layouts.frontend.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .dashboard-container {
        background-color: #E5E4E2;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .dashboard-container h2 {
        font-weight: 600;
        color: #4b3f72;
        margin-bottom: 10px;
    }
    .dashboard-container p {
        color: #555;
        font-size: 16px;
    }
</style>

<div class="dashboard-container">
    <h2>Welcome Back, {{ Auth::user()->name ?? 'Admin' }} 👋</h2>
    <p>Here’s your admin dashboard overview. You can manage your content, users, and settings from the sidebar.</p>
</div>
@endsection
