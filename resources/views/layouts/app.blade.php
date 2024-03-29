<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Website icon -->
    <link rel="icon" href="{{asset('images/website/k-logo.jpg')}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav id="navbar">
            <div class="left">
                @if (Auth::check())
                    <div class="user-image circle-image">
                        @if(Auth::user()->image)
                        <img src="{{asset('storage/' . Auth::user()->image->url)}}" alt="User photo">
                        @else
                        <img src="{{asset('images/users/default.jpg')}}" alt="User photo">
                        @endif
                    </div>
                @endif
                <h3 class="text-center">
                    <a class="text-white{{request()->is('users/editProfile') ? " active-link" : ""}}" href="{{asset('users/editProfile')}}">{{Auth::user()->name}}</a>
                </h3>
                <div class="sidebar">
                    <ul class="elements">
                        <a class="nav-link" href="{{route('home')}}">
                            <li class='{{request()->is('home') ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/home.png')}}" alt="Home">
                                </div>
                                <span class="link-label">Home</span>
                            </li>
                        </a>
                        <a class="nav-link" href="{{Auth::user()->role == 0 ? route('course.student.index') : route('course.index')}}">
                            <li class='{{request()->is('courses') ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/courses.png')}}" alt="Courses">
                                </div>
                                <span class="link-label">Courses</span>
                            </li>
                        </a>
                        <a class="nav-link" href="{{Auth::user()->role == 0 ? route('exams.student.index') : route('exams.index')}}">
                            <li class='{{request()->is('exams') ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/exams.png')}}" alt="Exams">
                                </div>
                                <span class="link-label">Exams</span>
                            </li>
                        </a>
                        @if (Auth::user()->role == 1)
                            <a class="nav-link" href="{{route('questionsbank.index')}}">
                                <li class='{{request()->is('questionBanks') ? "active" : ""}}'>
                                    <div class="nav-link-image circle-image">
                                        <img src="{{asset('images/website/nav-links/question-banks.png')}}" alt="Question Banks">
                                    </div>
                                    <span class="link-label">Question Banks</span>
                                </li>
                            </a>
                        @endif
                        <a class="nav-link" href="/logout">
                            <li>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/logout.png')}}" alt="Logout">
                                </div>
                                <span class="link-label">Logout</span>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
