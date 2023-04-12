<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Дипломне проєктування</title>
    <link rel="icon" href="https://www.college.uzhnu.edu.ua/wp-content/uploads/2020/09/ll1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg sticky-top bg-light navbar-light">
        <div class="container-fluid ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav text-center me-auto mb-2 mb-lg-0" >
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $homeLink }}"
                           href=" {{ route('home')  }}">Головна сторінка</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $docsLink }}"
                           href="{{ route('docs')  }}">Документи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $themesLink }}"
                           href="{{ route('themes')  }}">Перелік тем</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $selectedThemesLink }}"
                           href="{{ route('selected_themes')  }}">Перелік обраних тем</a>
                    </li>
                </ul>
                <ul class="navbar-nav text-center mb-2 mb-lg-0 d-flex">
                    <li class="nav-item">
                        <a class="nav-link menu-link "
                           href="/admin">Викладачам</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $studentLink }}"
                           href="{{ route('google') }}">Студентам</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('hero')
    @yield('content')
</div>
</body>
</html>
