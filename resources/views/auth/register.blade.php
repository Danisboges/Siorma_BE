<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

     <!-- Font Icon -->
    <link rel="stylesheet" href="{{asset ('distlogin/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{asset ('distlogin/css/style.css')}}">
</head>
<body>

    <div class="main">
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">REGISTER</h2>
                        @if ($errors->any())
                            <div>class="alert alert-danger"</div>
                                <ul>
                                    @foreach ($errors->all() as $error )
                                        <li>{{$error}}</li>    
                                    @endforeach
                                <ul>
                        @endif
                        
                        <form action= "{{ route('register') }}" method="POST" class="register-form" id="register-form">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Nama Lengkap"/>
                            </div>
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" placeholder="Username" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Alamat Email"/>
                            </div>
                            <div class="form-group" style="display: flex; align-items: center; position: relative;">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" placeholder="Password" style="flex: 1; padding-right: 30px;" />
                                <i class="zmdi zmdi-eye" id="togglePassword" style="cursor: pointer; position: absolute; right: 10px;"></i>
                            </div>
                            <div class="form-group" style="display: flex; align-items: center; position: relative;">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" style="flex: 1; padding-right: 30px;" />
                                <i class="zmdi zmdi-eye" id="toggleConfirmPassword" style="cursor: pointer; position: absolute; right: 10px;"></i>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                            {{-- <div class="from-group from-button">
                                <input type="submit" name ="signup" id="signup" class="from-submit" value="Register"/>
                            </div> --}}
                            <div>
                                <p>Sudah punya akun?</p>
                                <a href="{{route('login')}}">LOG IN</a>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{asset ('distlogin/images/logo_web_pengumuman.png')}}" alt="sing up image"></figure>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dist_login/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist_login/js/main.js') }}"></script>


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
        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        let confirmInput = document.getElementById('password_confirmation');
        if (confirmInput.type === 'password') {
            confirmInput.type = 'text';
            this.classList.remove('zmdi-eye');
            this.classList.add('zmdi-eye-off');
        } else {
            confirmInput.type = 'password';
            this.classList.remove('zmdi-eye-off');
            this.classList.add('zmdi-eye');
        }
    });
    </script>
</body>
</html>