<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Custom fonts -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: url("assets/img/bg.png") no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height:100vh;">
            <div class="col-lg-5">
                <div class="card shadow-lg my-5">
                    <div class="card-body p-4">
                        <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-group">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" class="form-control form-control-user" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter Email Address..." />
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <x-primary-button class="btn btn-primary btn-user btn-block">
                                            {{ __('Email Password Reset Link') }}
                                        </x-primary-button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{route ('register')}}">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{route ('login')}}">Already have an account? Login!</a>
                                    </div>
                                </div>

                        </form>
                        <!-- End Form -->
                    </div>
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
