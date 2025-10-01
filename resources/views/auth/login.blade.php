<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('distlogin/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('distlogin/css/style.css') }}">
</head>
<body>
<div class="main">
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure>
                        <img src="{{ asset('distlogin/images/logo_web_pengumuman.png') }}" alt="sign in image">
                    </figure>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">LOG IN</h2>

                    <!-- ✅ Pesan sukses -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- ❌ Error validasi -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('proseslogin') }}" method="POST" class="register-form" id="login-form">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="email" name="email" id="email" placeholder="Alamat Email" required value="{{ old('email') }}" />
                        </div>

                        <!-- Password + Toggle -->
                        <div class="form-group" style="display: flex; align-items: center; position: relative;">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Password" required style="flex: 1; padding-right: 30px;" />
                            <i class="zmdi zmdi-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 10px;"></i>
                        </div>

                        <!-- Submit -->
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                        </div>
                    </form>

                    <!-- Link ke Register -->
                    <div class="mt-2">
                        <p>Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JS -->
<script src="{{ asset('distlogin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('distlogin/js/main.js') }}"></script>

<!-- Toggle password -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('zmdi-eye');
            this.classList.add('zmdi-eye-off');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('zmdi-eye-off');
            this.classList.add('zmdi-eye');
        }
    });
</script>
</body>
</html>
