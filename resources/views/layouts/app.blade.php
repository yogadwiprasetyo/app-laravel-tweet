<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>App Laravel Tweet</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand a-custom" href="{{ url('/') }}">
                    App Laravel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav nav-pills ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a  class="nav-link" 
                                    href="{{ route('home') }}">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a  class="nav-link"
                                    href="{{ route('welcome') }}">
                                    Design Application
                                </a>
                            </li>
                            <li class="nav-item">
                                <a  class="nav-link" 
                                    href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                            <li class="nav-item">
                                <a  class="nav-link active text-white px-2" 
                                    href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" 
                                       href="{{ route('home') }}">
                                        Home
                                    </a>

                                    <a class="dropdown-item" 
                                       href="{{ route('profile.index', ['id' => Auth::user()->id]) }}">
                                        Profile
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <div class="content-footer">
              <a
                href="https://laravel.com/"
                target="_blank"
                class="icon-footer"
                title="Laravel"
              >
              <ion-icon name="logo-laravel"></ion-icon>
              </a>
              <a
                href="https://getbootstrap.com/"
                target="_blank"
                class="icon-footer"
                title="Bootstrap"
              >
                <svg class="icon-bs" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bootstrap-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.002 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4h-8zm1.06 12h3.475c1.804 0 2.888-.908 2.888-2.396 0-1.102-.761-1.916-1.904-2.034v-.1c.832-.14 1.482-.93 1.482-1.816 0-1.3-.955-2.11-2.542-2.11H5.062V12zm1.313-4.875V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23H6.375zm0 3.762h1.898c1.184 0 1.81-.48 1.81-1.377 0-.885-.65-1.348-1.886-1.348H6.375v2.725z"/>
                </svg>
              </a>
              <a
                href="https://github.com/yogadwiprasetyo"
                target="_blank"
                class="icon-footer"
                title="Github"
              >
                <ion-icon name="logo-github"></ion-icon>
              </a>
            </div>
            <p>&copy; 2020 ypsrty</p>
        </footer>
    </div>

    <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
</body>
</html>