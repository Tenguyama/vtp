<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Дипломне проєктування</title>
    <link rel="icon" href="https://www.college.uzhnu.edu.ua/wp-content/uploads/2020/09/ll1.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


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
    <div class="container-fluid ">
        <div class="container-fluid text-center">
            <br/>
            <h2 class="h2 pt-2">Привіт, {{$student->name}} !</h2>
            @if($isSelectedTheme)
            <p> Ви вже обрали собі тему на дипломне проєктування.</p>
                <br/>
        </div>
            <div class="container-fluid">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Студент</th>
                        <th scope="col">Група</th>
                        <th scope="col">Тема</th>
                        <th scope="col">Керівник</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr>
                            <th scope="row">1</th>
                            <td>{{$isSelectedTheme->student_name}}</td>
                            <td>{{$isSelectedTheme->group_name}}</td>
                            <td>{{$isSelectedTheme->theme_name}}</td>
                            <td>{{$isSelectedTheme->user_name}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <p> Тут ви зможете обрати собі тему на дипломне проєктування.</p>
                <br/>
        </div>
        <div>
            <form id="my-form" method="POST" action="/submit">
                @csrf
                <select id="group-select" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option selected="">Оберіть свою групу</option>
                    @foreach($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
                <br/>
                <select id="theme-select" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option selected="">Оберіть бажану тему</option>
                    @foreach($themes as $theme)
                        <option value="{{$theme->theme_id}}">{{$theme->theme_name}} ({{$theme->user_name}})</option>
                    @endforeach
                </select>
                <br/>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button id="submit-button" type="submit" class="btn btn-outline-dark w-100">Підтвердити вибір теми</button>
                </div>
            </form>
        </div>
    @endif
</div>
</body>
</html>
<script>
    var token = document.head.querySelector('meta[name="csrf-token"]').content;

    document.getElementById("my-form").addEventListener("submit", function(event) {
        event.preventDefault();

        var groupSelect = document.getElementById("group-select");
        var themeSelect = document.getElementById("theme-select");

        var groupSelectedOption = groupSelect.options[groupSelect.selectedIndex].value;
        var themeSelectedOption = themeSelect.options[themeSelect.selectedIndex].value;

        if (groupSelectedOption && themeSelectedOption) {

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "student/save", true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', token);
            //
            //
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // перенаправлення на інший маршрут
                        window.location.href = "{{ route('student') }}";
                    } else {
                        // виведення повідомлення про помилку
                        alert("Помилка при відправці запиту"); // не робить
                    }
                }
            };
            //
            //
            xhr.send(JSON.stringify({
                group_id: groupSelectedOption,
                theme_id: themeSelectedOption
            }));
        } else {
            alert("Виберіть свою групу та бажану тему!"); // не робить
        }
    });
</script>


