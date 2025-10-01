<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    // 🔹 Proses login
    public function prosesLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            //'g-recaptcha-response' => 'required|captcha',
        ]);

        $key = 'login|' . $request->email . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return redirect()->route('blocked', ['email' => $request->email]);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            RateLimiter::clear($key);
            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'user'  => redirect()->route('user.dashboard'),
                default => redirect()->route('login')->with('error', 'Role tidak dikenali'),
            };
        }

        RateLimiter::hit($key, 60);
        return back()->withInput()->withErrors(['email' => 'Email atau password salah.']);
    }

    // 🔹 Halaman form register
    public function showRegister() 
    { 
        return view('auth.register'); 
    }

    // 🔹 Proses register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default role user
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // 🔹 Dashboard umum
    public function dashboard() 
    { 
        return view('dashboard'); 
    }

    // 🔹 Dashboard khusus admin
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('dashboardadmin');
    }

    // 🔹 Dashboard khusus user
    public function userDashboard()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'user'])) {
            return view('dashboarduser');
        }
        abort(403);
    }

    // =========================
    // 🔹 MANAGE USERS (CRUD)
    // =========================
    public function manageUsers()
    {
        $roles = ['admin', 'user', 'bendahara', 'sales'];
        $users = User::latest()->get(); 
        return view('admin.manage_users', compact('roles', 'users'));
    }

    public function adminAddUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,user,bendahara,sales'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.manageUsers')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'user', 'bendahara', 'sales'];
        return view('admin.edit-user', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,user,bendahara,sales',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.manageUsers')->with('success', 'User berhasil diperbarui!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.manageUsers')->with('success', 'User berhasil dihapus!');
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // 🔹 Jika user diblokir karena salah login berkali-kali
    public function showBlocked(Request $request)
    {
        $email = $request->query('email');
        $ip = $request->ip();

        if (!$email) return redirect()->route('login');

        $key = 'login|' . $email . '|' . $ip;
        $seconds = RateLimiter::availableIn($key);

        return view('auth.blocked', compact('seconds'));
    }
}
