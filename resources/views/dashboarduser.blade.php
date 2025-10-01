<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }

        /* 🌙 Dark Mode */
        body.dark-mode {
            background-color: #121212;
            color: #f1f1f1;
        }

        body.dark-mode .navbar {
            background-color: rgba(30, 30, 30, 0.85) !important;
            backdrop-filter: blur(10px);
        }

        body.dark-mode .card,
        body.dark-mode .alert,
        body.dark-mode .form-control,
        body.dark-mode .btn {
            background-color: #2b2b2b;
            color: #f1f1f1;
            border-color: #444;
        }

        body.dark-mode .card-header {
            background-color: #333;
            color: #f1f1f1;
        }

        /* 🧊 Glassmorphism Navbar */
        .navbar {
            background-color: rgba(0, 0, 0, 0.75) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card-header {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    </style>
</head>
<body class="{{ session('dark_mode') ? 'dark-mode' : '' }}">

@php use Illuminate\Support\Facades\Auth; @endphp

<!-- 🔵 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-3 sticky-top">
    <a class="navbar-brand" href="#">🚀 Dashboard</a>

    <div class="ms-auto d-flex align-items-center gap-2">
        <!-- 🌗 Dark Mode Toggle -->
        <form method="POST" action="{{ route('toggleDarkMode') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light" title="Toggle Dark Mode">
                @if(session('dark_mode'))
                    <i class="bi bi-sun-fill"></i>
                @else
                    <i class="bi bi-moon-stars-fill"></i>
                @endif
            </button>
        </form>

        <!-- 🧭 Link ke Admin -->
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-light shadow-sm" title="Ke Dashboard Admin">
                <i class="bi bi-person-square"></i>
            </a>
        @endif

        <!-- 👤 User Info -->
        @if(Auth::check())
            <span class="text-white small">{{ Auth::user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Foto Profil" class="profile-img">

            <!-- 🔓 Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mb-0 ms-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        @endif
    </div>
</nav>

<!-- 🔽 Main Content -->
<div class="container py-5">
    <h2 class="mb-4 fw-semibold">Selamat Datang, {{ Auth::user()->name }} 👋</h2>

    <!-- ℹ️ Informasi Umum -->
    <div class="card">
        <div class="card-header bg-primary text-white fw-medium">
            ℹ️ Informasi Umum
        </div>
        <div class="card-body">
            <p>Halo <strong>{{ Auth::user()->name }}</strong>! Terima kasih telah menggunakan sistem kami.</p>
            <p>Di halaman ini Anda dapat mengakses informasi penting sesuai peran Anda sebagai <strong>{{ Auth::user()->role }}</strong>.</p>
            <p>Jika membutuhkan bantuan, silakan hubungi admin.</p>
        </div>
    </div>
</div>

<!-- 🧩 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
