<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

    <!-- Title -->
    <title>Admin Login</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="">
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">

</head>

<body class="vh-100">

    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <img src="images/ibb-logo.png" alt="" style="width:7rem; height:7rem;">

                                    </div>

                                    <h4 class="text-center mb-4 fs-3">Welcome Admin</h4>
                                    <form action="{{ route('admin.login') }}" method="POST">
                                        @csrf
                                        <div class="form-group fs-5">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="hello@gmail.com" value="{{ old('email') }}">
                                            @error('email')
                                            <p style="color:red;">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <label class="form-label fs-5">Password</label>
                                        <div class="mb-3 position-relative fs-5">
                                            <input type="password" name="password" id="dz-password" class="form-control" placeholder="123456">
                                            <span class="show-pass eye">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>

                                            @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="js/demo.js"></script>
    <script src="js/styleSwitcher.js"></script>

</body>


</html>