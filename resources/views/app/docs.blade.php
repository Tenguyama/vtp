@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="container-fluid text-center">
            <br/>
            <h2 class="h2 pt-2">Перелік документів, що супроводжують дипломне проєктування</h2>
            <br/>
        </div>
        <div class="container-fluid">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Назва</th>
                    <th scope="col">Посилання на завантаження <i class="bi bi-link-45deg"></i></th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($links as $link)
                    <tr>
                        <th scope="row">{{$index++}}</th>
                        <td>{{$link['docs_name']}}</td>
                        <td><a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                               href="{{$link['link']}}"
                               download="{{$link['file_name']}}"><i class="bi bi-link-45deg"></i> Завантажити <i class="bi bi-download"></i> </a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
