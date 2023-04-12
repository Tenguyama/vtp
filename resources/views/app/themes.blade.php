@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="container-fluid text-center">
            <br/>
            <h2 class="h2 pt-2">Запропоновані керівниками теми дипломного проєктування</h2>
            <br/>
        </div>
        <div class="container-fluid">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Тема</th>
                    <th scope="col">Керівник</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($themes as $theme)
                    <tr>
                        <th scope="row">{{$index++}}</th>
                        <td>{{$theme->theme_name}}</td>
                        <td>{{$theme->user_name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
