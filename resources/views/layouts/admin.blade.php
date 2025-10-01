<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background-color: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: white;
            padding: 0.75rem 1rem;
            display: block;
            text-decoration: none;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex-grow: 1;
            padding: 2rem;
            background-color: #f8f9fa;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        /* DARK MODE */
        body.dark-mode {
            background-color: #121212;
            color: #f1f1f1;
        }
        body.dark-mode .main-content {
            background-color: #1e1e1e;
            color: #f1f1f1;
        }
        body.dark-mode .card,
        body.dark-mode .modal-content {
            background-color: #2c2c2c;
            color: #f1f1f1;
        }
        body.dark-mode .form-control,
        body.dark-mode .form-select,
        body.dark-mode input[type="file"] {
            background-color: #3a3a3a;
            color: #fff;
            border-color: #555;
        }
        body.dark-mode .form-control::placeholder,
        body.dark-mode textarea::placeholder {
            color: #ccc;
        }
        body.dark-mode .table {
            background-color: #2b2b2b;
            color: #fff;
            border-color: #444;
        }
        body.dark-mode .table th,
        body.dark-mode .table td {
            color: #f1f1f1;
            background-color: #2b2b2b;
            border-color: #444;
        }
        body.dark-mode .alert {
            background-color: #444;
            color: #f1f1f1;
        }
        .table td {
            word-break: break-word;
        }
        .avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .sidebar-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .sidebar-header-left {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .sidebar-header h6 {
            margin: 0;
            font-size: 0.9rem;
            color: white;
            max-width: 100px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-header form {
            margin: 0;
        }
        .sidebar-header button {
            background: none;
            border: none;
            color: white;
            font-size: 1.1rem;
        }
    </style>
</head>
<body class="{{ session('dark_mode') ? 'dark-mode' : '' }}">
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <!-- Header: Avatar, Name, Logout -->
            <div class="sidebar-header">
                <div class="sidebar-header-left">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                         alt="Avatar" class="avatar-small">
                    <h6>{{ $user->name }}</h6>
                </div>
                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Logout sekarang?')">
                    @csrf
                    <button type="submit" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>

            <!-- Menu Links -->
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.manageUsers') }}" class="{{ request()->routeIs('admin.manageUsers') ? 'active' : '' }}">
                <i class="bi bi-people me-2"></i> Manajemen User
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>@yield('title', 'Dashboard Admin')</h4>
            <!-- Tombol Dark Mode -->
            <form method="POST" action="{{ route('toggleDarkMode') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary" title="Dark/Light Mode">
                    @if(session('dark_mode'))
                        <i class="bi bi-sun-fill"></i>
                    @else
                        <i class="bi bi-moon-stars-fill"></i>
                    @endif
                </button>
            </form>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
