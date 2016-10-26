<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="My blog implemented by laravel 5.3">
    <meta name="author" content="Hashem Moghaddari <hashemm364@gmail.com>">
    <title>HamoBlog</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Select2 StyleSheet--}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

    @yield('styles')

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">HamoBlog</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @if(Request::is('/')) class="active" @endif><a href="{{ route('home') }}">Home</a></li>
                <li @if(Request::is('about-me')) class="active" @endif><a href="{{ route('about') }}">About</a></li>
                <li @if(Request::is('contact-me')) class="active" @endif><a href="{{ route('contact') }}">Contact</a></li>
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li @if(Request::is('login')) class="active" @endif><a href="{{ route('login') }}">Login</a></li>
                    <li @if(Request::is('register')) class="active" @endif><a href="{{ url('register') }}">Register</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">

    <div class="starter-template">
        @yield('content')
    </div>

</div><!-- /.container -->

<footer class="footer">
    <div class="container">
        <p class="text-muted text-center">Developer: <a href="https://github.com/hamog">Hashem Moghaddari</a></p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('js/jquery-3.1.0.min.js') }}"> </script>
<script src="{{ asset('js/app.js') }}"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.0.1/vue-resource.min.js"> </script>
<script src="{{ asset('js/main.js') }}"> </script>
<script src="{{ asset('js/select2.min.js') }}"> </script>
<script src="{{ asset('js/sweetalert.min.js') }}"> </script>
@include('vendor.alerts.alerts')
@yield('js')
</body>
</html>
