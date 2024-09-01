<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Admin Dashboard</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="">

    <meta name="format-detection" content="telephone=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link class="main-css" href="css/style.css" rel="stylesheet">
    <style>
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 15px;
            margin-top: 40px;
        }

        .username,
        .email,
        .logout-link {
            text-align: center;
            margin-bottom: 10px;
        }

        .preview {
            width: 24rem;
            height: 20rem;
        }

        .document-link.active {
            color: #c5f0d1;
            /* Change text color to green when active */
        }
    </style>
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{route('admin.dashboard')}}" class="brand-logo">
                <img src="images/ibb-logo.png" alt="" style="width:5rem; height:5rem;">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Chat box start
        ***********************************-->


        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                <a href="{{route('admin.dashboard')}}">Dashboard</a>

                            </div>
                        </div>

                        <!-- NOTIFICATION HEADER CONTAINER -->
                        <ul class="navbar-nav header-right">

                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dz-theme-mode" href="javascript:void(0);">
                                    <i id="icon-light" class="fas fa-sun"></i>
                                    <i id="icon-dark" class="fas fa-moon"></i>

                                </a>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:;" role="button" data-bs-toggle="dropdown">
                                    <img src="images/profile/12.png" width="20" alt="">
                                    <div class="header-info">
                                        <span>Hello, <strong>{{ Auth::guard('admin')->user()->name }}</strong></span>

                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="app-profile.html" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ms-2">Profile </span>
                                    </a>
                                    <a href="email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <span class="ms-2">Inbox </span>
                                    </a>


                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ms-2">Logout </span>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>

                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">

                <div class="sidebar d-flex flex-column align-items-center">
                    <img src="images/avatar/1.jpg" alt="Profile Picture" class="profile-pic">
                    <h4 class="username"> {{ Auth::guard('admin')->user()->name }}</h4>
                    <p class="email">{{ Auth::guard('admin')->user()->email }}</p>

                    <ul class="list-group list-group-flush mt-4">
                        @php
                        $loggedInUser = Auth::guard('admin')->user();
                        $isSuperAdmin = $loggedInUser->faculty_id == 0 && $loggedInUser->dept_id == 0;

                        @endphp

                        @if($isSuperAdmin)
                        <!-- links for super admins only-->
                        <a href="{{route('admin.manage-staff')}}" class="list-group-item">Manage Staff</a>

                        @endif

                        <!-- links for Aall admins -->
                        <a href="/admin-manage-students" class="list-group-item">Manage Students</a> <br />
                        <a href="{{route('admin.show-change-password')}}" class="list-group-item">Change Password</a>
                        <a class="list-group-item" style="color: red;" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </a>


                    </ul>

                </div>



            </div>
        </div>

        <!-- main content -->
        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>








        <!-- Required vendors -->
        <script src="vendor/global/global.min.js"></script>
        <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

        <!-- Dashboard 1 -->
        <script src="js/custom.min.js"></script>
        <script src="js/deznav-init.js"></script>
        <script src="js/demo.js"></script>
        <script src="js/styleSwitcher.js"></script>



</body>


</html>