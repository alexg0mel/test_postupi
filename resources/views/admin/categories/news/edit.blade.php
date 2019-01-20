@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')


    <form method="POST" action="{{ route('admin.categories.news.update', ['category' => $category, 'news' => $news]) }}" onsubmit="return submitForm(this);">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name_news" class="col-form-label">Name</label>
            <input id="name_news" class="form-control{{ $errors->has('name_news') ? ' is-invalid' : '' }}" name="name_news" value="{{ old('name_news', $news->name_news) }}" required>
            @if ($errors->has('name_news'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name_news') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug" class="col-form-label">Slug</label>
            <input id="slug" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug', $news->slug) }}" required>
            @if ($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="body_news" class="col-form-label">Text</label>
            <input id="body_news" class="form-control{{ $errors->has('body_news') ? ' is-invalid' : '' }}" name="body_news" value="{{ old('body_news', $news->body_news) }}" required>
            @if ($errors->has('body_news'))
                <span class="invalid-feedback"><strong>{{ $errors->first('body_news') }}</strong></span>
            @endif
        </div>



        <div class="form-group">
            <button type="submit" id="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection

