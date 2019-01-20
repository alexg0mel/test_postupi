@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary mr-1">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>ID</th><td>{{ $category->id }}</td>
        </tr>
        <tr>
            <th>Name</th><td>{{ $category->name_categ }}</td>
        </tr>
        <tr>
            <th>Slug</th><td>{{ $category->slug }}</td>
        </tr>
        <tr>
            <th>Descr</th><td>{{ $category->descr }}</td>
        </tr>

        <tbody>
        </tbody>
    </table>
    <p><a href="{{ route('admin.categories.news.create', $category) }}" class="btn btn-success">Добавить новость</a></p>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th><th>Slug</th> <th>Body</th>
        </tr>
        </thead>
        <tbody>

        @forelse ($category->news as $news)
            <tr>
                <td>
                    <a href="{{ route('admin.categories.news.show', [$category, $news]) }}">{{ $news->name_news }}</a>
                </td>
                <td>
                    {{ $news->slug }}
                </td>
                <td>
                    {!! $news->body_news !!}
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Новостей нет...</td></tr>
        @endforelse

        </tbody>
    </table>

@endsection