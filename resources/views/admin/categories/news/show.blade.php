@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')
    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.categories.news.edit', ['category' =>$category, 'news' => $news]) }}" class="btn btn-primary mr-1">Редактировать</a>
        <form method="POST" action="{{ route('admin.categories.news.update', ['category' =>$category, 'news' => $news]) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Удалить</button>
        </form>
    </div>


    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $news->id }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $news->name_news }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $news->slug }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $news->body_news }}</td>
        </tr>

        </tbody>
    </table>


@endsection