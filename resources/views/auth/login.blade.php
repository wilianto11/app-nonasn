<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Login Absensi Non ASN</title>
    <meta name="description" content="Finapp HTML Mobile Template">
    <meta name="keywords"
        content="bootstrap, wallet, banking, fintech mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="{{ asset(' sizes="32x32') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
</head>

<body>



    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">

        </div>
        <div class="pageTitle"></div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="login-form mt-1">
            <div class="section mt-2 text-center">
                <img src="{{ asset('assets/img/icon/Kabupaten Bekasi.png') }}" alt="image" height="170"
                    width="170" class="form-image">
            </div>
            <div class="section mt-2 text-center">
                <h1>Absensi Non ASN</h1>
                <h4>Isi Form untuk Login</h4>
            </div>
            <div class="section mb-5 p-2">
                @php
                    $message = Session::get('error');
                @endphp
                @if (Session::get('error'))
                    <div class="alert alert-outline-danger">
                        {{ $message }}
                    </div>
                @endif

                <form action="{{ route('Login') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body pb-1">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="nik">User Name</label>
                                    <input type="text" name="user_name" class="form-control" id="user_name"
                                        placeholder="User Namer">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        autocomplete="off" placeholder="Your password">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-links mt-2">

                    </div>

                    <div class="form-button-group  transparent">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>
                    </div>

                </form>
            </div>

        </div>
        <!-- * App Capsule -->



        <!-- ========= JS Files =========  -->
        <!-- Bootstrap -->
        <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
        <!-- Ionicons -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <!-- Splide -->
        <script src="{{ asset('assets/js/plugins/splide/splide.min.js') }}"></script>
        <!-- Base Js File -->
        <script src="{{ asset('assets/js/base.js') }}"></script>


</body>

</html>
