<!DOCTYPE html>
<html lang="en">

{{-- Head --}}

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="templates/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/image/logo-harber.png">
    <title>
        Sistem Akreditasi
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/login.css" rel="stylesheet" />
</head>

<body class="">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Selamat datang</h4>
                                    <p class="mb-0">Masuk untuk melanjutkan</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <!-- Email Address -->
                                        <div class="mb-3">
                                            <input id="email" type="email" name="email" :value="old('email')" required
                                                autofocus autocomplete="username" class="form-control form-control-lg"
                                                placeholder="Email" aria-label="Email">
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <input id="password" type="password" name="password" required
                                                autocomplete="current-password" class="form-control form-control-lg"
                                                placeholder="Password" aria-label="Password">
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        <!-- Remember Me -->
                                        {{-- <div class="form-check form-switch">
                                            <input id="remember_me" type="checkbox" class="form-check-input"
                                                name="remember">
                                            <label class="form-check-label"
                                                for="remember_me">{{ __('Ingat saya') }}</label>
                                        </div> --}}

                                        <div class="text-center mt-4">
                                            <!-- @if (Route::has('password.request'))
                                                <a class="d-block text-sm text-gray-600 hover:text-gray-900 mb-2"
                                                    href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif -->

                                            <button type="submit"
                                                class="btn btn-lg btn-primary w-100 mt-2">{{ __('Masuk') }}</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('/assets/image/banner.jpg'); background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6 d-flex align-items-center">
                                    <div class="container text-start ms-5">
                                        <h1 class="text-white fw-bold" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">ILEDIN</h1>
                                        <p class="text-white" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">Instrumen Laporan Evaluasi Diri Internal</p>
                                    </div>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>