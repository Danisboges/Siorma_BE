<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;


// 🔑 Login (GET)
Route::get('/', function (Request $request) {
    $email = $request->old('email') ?? $request->query('email');
    $key = 'login|' . $email . '|' . $request->ip();

    if ($email && RateLimiter::tooManyAttempts($key, 5)) {
        return redirect()->route('blocked', ['email' => $email]);
    }

    return view('auth.login');
})->name('login');

// 🔑 Login (POST)
Route::post('/proseslogin', [AuthController::class, 'prosesLogin'])->name('proseslogin');

// 📝 Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 🚫 Blocked login
Route::get('/blocked', [AuthController::class, 'showBlocked'])->name('blocked');


Route::middleware(['auth'])->group(function () {

    // 📌 Dashboard umum (redirect sesuai role di AuthController)
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // 👨‍💼 Dashboard Admin
    Route::prefix('dashboard/admin')
        ->middleware([RoleMiddleware::class . ':admin'])
        ->name('admin.')
        ->group(function () {
            // Halaman utama admin
            Route::get('/', [AuthController::class, 'adminDashboard'])->name('dashboard');

            // 👥 Manajemen User
            Route::get('/users', [AuthController::class, 'manageUsers'])->name('manageUsers');
            Route::post('/users', [AuthController::class, 'adminAddUser'])->name('addUser');
            Route::get('/users/{id}/edit', [AuthController::class, 'editUser'])->name('editUser');
            Route::put('/users/{id}', [AuthController::class, 'updateUser'])->name('updateUser');
            Route::delete('/users/{id}', [AuthController::class, 'deleteUser'])->name('deleteUser');
        });

    // 👤 Dashboard User
    Route::prefix('dashboard/user')
        ->middleware([RoleMiddleware::class . ':admin,user'])
        ->name('user.')
        ->group(function () {
            Route::get('/', [AuthController::class, 'userDashboard'])->name('dashboard');
        });

    // 🔓 Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ⚙️ Toggle Dark Mode
    Route::post('/toggle-dark-mode', function () {
        session(['dark_mode' => !session('dark_mode')]);
        return back();
    })->name('toggleDarkMode');

    // ✅ Route testing middleware
    Route::get('/test', fn () => 'Middleware berhasil diload.')->middleware('testmiddleware');
    Route::get('/cek-role', fn () => 'Role middleware aktif!')->middleware([RoleMiddleware::class . ':admin']);
});
