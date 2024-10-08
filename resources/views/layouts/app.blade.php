<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container align-items-center">
            <a class="navbar-brand" href="/"><img src="{{asset('images/logo.png')}}" alt="" style="height: 30px; vertical-align: sub"> <span class="ms-2 mt-3">E-Clinics <strong>Admins</strong></span></a>
            <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"></span>
            </button>
            <div class="collapse navbar-collapse ms-5" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/clinic">Clinics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/reservation">Reservations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/question">Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/feedback">Feedbacks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/history">Histories</a>
                        </li>
                    @endauth
                </ul>
                <ul class="mb-2 mb-lg-0 list-unstyled d-lg-flex">
                    @guest()
                        <li class="nav-item mb-3 mb-lg-0 me-lg-3">
                            <a class="btn btn-outline-success" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                    @auth()
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">
    @yield('content')
</div>

<footer class="bg-dark fixed-bottom text-center text-light">
    <div class="container">
        <p class="p-0 my-2">&copy; {{ date('Y') }} Clinics Management App</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
