@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4"> 
    <h2 class="mb-4">Selamat Datang, {{ auth()->user()->name }} 👋</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Dashboard Admin</h5>
            <p class="card-text mb-0">
                Anda berhasil login sebagai <strong>{{ auth()->user()->role }}</strong>.
            </p>
        </div>
    </div>
</div>
@endsection
