<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

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
                        <img src="{{asset('images/users/' . Auth::user()->image)}}" alt="User photo">
                        @else
                        <img src="{{asset('images/users/default.jpg')}}" alt="User photo">
                        @endif
                    </div>
                @endif
                <h3 class="text-center">
                    <a class="text-white" href="">{{Auth::user()->username}}</a>
                </h3>
                <div class="sidebar">
                    <ul class="elements">
                        <a class="nav-link" href="#">
                            <li class='{{$active == "home" ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/home.png')}}" alt="Home">
                                </div>
                                <span class="link-label">Home</span>
                            </li>
                        </a>
                        <a class="nav-link" href="#">
                            <li class='{{$active == "courses" ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/courses.png')}}" alt="Courses">
                                </div>
                                <span class="link-label">Courses</span>
                            </li>
                        </a>
                        <a class="nav-link" href="#">
                            <li class='{{$active == "exams" ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/exams.png')}}" alt="Exams">
                                </div>
                                <span class="link-label">Exams</span>
                            </li>
                        </a>
                        <a class="nav-link" href="#">
                            <li class='{{$active == "questionBanks" ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/question-banks.png')}}" alt="Question Banks">
                                </div>
                                <span class="link-label">Question Banks</span>
                            </li>
                        </a>
                        <a class="nav-link" href="#">
                            <li class='{{$active == "examsAnalysis" ? "active" : ""}}'>
                                <div class="nav-link-image circle-image">
                                    <img src="{{asset('images/website/nav-links/exam-analysis.png')}}" alt="Exam Analysis">
                                </div>
                                <span class="link-label">Exams Analysis</span>
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
