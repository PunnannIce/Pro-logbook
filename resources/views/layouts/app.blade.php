<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1828/1828884.png" type="image/png">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    {{-- pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    {{-- google font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan&family=Bai+Jamjuree:wght@400&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Anuphan', sans-serif !important;
            /*font-family: 'Bai Jamjuree', sans-serif !important;*/
            background-color: #f8f9fa;
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 20px;
        }

        .nav-link {
            font-weight: 500;
            color: #ffffff !important; 
            transition: color 0.3s ease, transform 0.3s ease; 
        }

        .nav-link:hover {
            color: #ffcc00 !important;
            transform: scale(1.1); 
        }

        .dropdown-menu {
            border-radius: 10px;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


</head>

<body data-bs-theme="dark">
    <div id="app">
        <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
            <div class="container">
                <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- สำหรับ Administrator -->
                            @if (Auth::user()->role == 'Administrator')
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeHome')" href=" ">{{ __('Home') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeUsers')"
                                        href="{{ route('user.index') }}">{{ __('Users') }}</a>
                                </li>
                            @endif

                            <!-- สำหรับ Teacher -->
                            @if (Auth::user()->role == 'Teacher')
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeSubject')"
                                        href="{{ route('location.index') }}">{{ __('สถานที่ฝึกงาน') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeTeacherLog')"
                                        href="{{ route('teacher.index') }}">{{ __('ตรวจสอบบันทึกประจำวัน') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeTeacherNotes')"
                                        href="{{ route('teacher.notes') }}">{{ __('บันทึกของอาจารย์นิเทศก์') }}</a>
                                </li>
                            @endif

                            <!-- สำหรับ Student -->
                            @if (Auth::user()->role == 'Student')
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeStudent')"
                                        href=" {{ route('student.index') }}">{{ __('ประวัติส่วนตัว') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeStudent')" 
                                        href="{{ route('student.log') }}">{{ __('ตรวจสอบบันทึกประจำวัน') }}</a>
                                </li>
                            @endif

                            <!-- สำหรับ Mentor -->
                            @if (Auth::user()->role == 'Mentor')
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeStudent')" href=" ">{{ __('พี่เลี้ยง') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('req') }}">{{ __('ลงทะเบียนพี่เลี้ยง') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  @yield('activeMentorLog')"
                                        href="{{ route('teacher.index') }}">{{ __('ตรวจสอบบันทึกประจำวัน') }}</a>
                                </li>
                            @endif

                            <!-- เมนู Logout -->
                            @auth
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endauth
                        @endguest
                        <li class="nav-item d-flex align-items-center">
                            <button id="theme-toggle" class="btn btn-outline-light btn-sm ms-2">
                                <i id="theme-icon" class="fas fa-moon"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            <div class="card shadow-sm p-4 rounded text-center">
                @yield('welcome')
                @yield('content')
            </div>
        </main>
    </div>

    {{-- ajax --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.5/sweetalert2.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.bootstrap5.js"></script>

    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const body = document.body;

            // Load saved theme from localStorage or use system preference
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const initialTheme = savedTheme || systemTheme;

            body.setAttribute('data-bs-theme', initialTheme);
            themeIcon.className = initialTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';

            themeToggle.addEventListener('click', function () {
                const currentTheme = body.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                body.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                themeIcon.className = newTheme === 'dark' ? 'fas fa-moon' : 'fas fa-sun';
            });
        });
    </script>

    @yield('scripts')

</body>

</html>
