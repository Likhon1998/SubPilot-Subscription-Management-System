<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SubPilot</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body style="background-color: Cornsilk;">
    <div class="container mt-5 text-center">
        <h1>Welcome, Admin!</h1>
        <p>You are logged in as <strong>{{ Auth::user()->name }}</strong></p>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">Logout</button>
        </form>
    </div>
</body>
</html>
