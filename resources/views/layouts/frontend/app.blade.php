<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar */
        .topbar {
            background-color: #fff;
            height: 70px;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .topbar .site-name {
            font-weight: 600;
            font-size: 22px;
            color: #5a4fcf;
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 220px;
            height: calc(100vh - 70px);
            background-color: #CBC3E3;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }

        .sidebar .nav-link {
            color: #000;
            font-weight: 500;
            background-color: #C3B1E1;
            margin: 8px 20px;
            border-radius: 10px;
            text-align: center;
            padding: 10px 0;
            transition: 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #b39ddb;
            color: white;
        }

        /* Main content */
        .content {
            margin-left: 240px;
            padding: 100px 30px 30px;
            font-family: 'Inter', sans-serif;
        }

        /* Dropdown */
        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            min-width: 150px;
            font-family: 'Inter', sans-serif;
        }

        /* Avatar with status */
        .avatar-wrapper {
            position: relative;
            display: inline-block;
        }

        .avatar-wrapper .status-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            background-color: #28a745; /* green */
            border: 2px solid white;
            border-radius: 50%;
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <div class="topbar d-flex justify-content-between">
        <div class="site-name">SUBPILOT</div>

        <!-- Admin avatar dropdown -->
        <div class="dropdown">
            <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" role="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar-wrapper me-2">
                    <img src="{{ asset('images/male-avatar.jpg') }}" alt="Admin" width="40" height="40" class="rounded-circle">
                    <span class="status-dot"></span>
                </div>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">Products</a>
        <a href="{{ route('admin.items.index') }}" class="nav-link {{ request()->is('admin/items*') ? 'active' : '' }}">Items</a>
        <a href="{{ route('admin.checkouts.index') }}" class="nav-link {{ request()->is('admin/checkouts*') ? 'active' : '' }}">Total users</a>
    </div>

    <!-- Page Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
