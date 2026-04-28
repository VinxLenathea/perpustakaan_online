<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Perpustakaan Online</title>

    <!-- Custom fonts -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.85) 0%, rgba(34, 74, 190, 0.9) 100%),
                        url("assets/img/logo rsmn1.png") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .login-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            padding: 35px 30px;
            text-align: center;
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50% 50% 0 0;
        }

        .login-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
            color: #fff;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .login-header h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin: 8px 0 0;
        }

        .login-body {
            padding: 30px 35px 35px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
            z-index: 10;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            color: #2d3748;
            background: #fff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4e73df;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .error-message {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .login-footer p {
            color: #718096;
            font-size: 13px;
            margin: 0;
        }

        .login-footer a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 25px 25px 30px;
            }

            .login-header {
                padding: 25px 20px;
            }

            .login-header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h1>Perpustakaan Online</h1>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="name" class="form-label">Username</label>
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input id="name" type="text" name="name" 
                                class="form-control" 
                                value="{{ old('name') }}" 
                                required autofocus 
                                placeholder="Masukkan username" />
                        </div>
                        @if($errors->has('name'))
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password" name="password" 
                                class="form-control" 
                                required 
                                placeholder="Masukkan password" />
                        </div>
                        @if($errors->has('password'))
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    <p>&copy; {{ date('Y') }} Perpustakaan Online. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts -->
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>

