@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <h3 class="mb-4">Manajemen User</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tambah User -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.addUser') }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="col-md-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-2">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="col-md-2">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    </div>
                    <div class="col-md-2">
                        <select name="role" class="form-select" required>
                            <option disabled selected>Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            {{-- <option value="bendahara">Bendahara</option>
                            <option value="sales">Sales</option> --}}
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-primary w-100">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $i => $u)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ ucfirst($u->role) }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.deleteUser', $u->id) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus user ini?')" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit -->
    @foreach($users as $u)
        <div class="modal fade" id="editUserModal{{ $u->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $u->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('admin.updateUser', $u->id) }}" class="modal-content">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel{{ $u->id }}">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control mb-2" value="{{ $u->name }}" required>
                        <input type="email" name="email" class="form-control mb-2" value="{{ $u->email }}" required>
                        <select name="role" class="form-select mb-2" required>
                            <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                            {{-- <option value="bendahara" {{ $u->role === 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                            <option value="sales" {{ $u->role === 'sales' ? 'selected' : '' }}>Sales</option> --}}
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
