<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel User Management</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('users.index') }}">User Management</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">All Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.trashed') }}">Trashed Users</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="mt-4">
        @yield('content')
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
