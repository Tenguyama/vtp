@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="container-fluid text-center">
            <br/>
            <h2 class="h2 pt-2">Обрані студентами теми дипломного проєктування</h2>
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
                @foreach($selectedThemes as $selectedTheme)
                    <tr>
                        <th scope="row">{{$index++}}</th>
                        <td>{{$selectedTheme->student_name}}</td>
                        <td>{{$selectedTheme->group_name}}</td>
                        <td>{{$selectedTheme->theme_name}}</td>
                        <td>{{$selectedTheme->user_name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
