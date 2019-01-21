@extends('layouts.app')

@section('content')
    @include('admin.categories._nav')

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <div class="form-group">
            <label for="name_categ" class="col-form-label">Name</label>
            <input id="name_categ" class="form-control{{ $errors->has('name_categ') ? ' is-invalid' : '' }}" name="name_categ" value="{{ old('name_categ') }}" required>
            @if ($errors->has('name_categ'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name_categ') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="slug" class="col-form-label">Slug</label>
            <input id="slug" type="text" class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug') }}" required>
            @if ($errors->has('slug'))
                <span class="invalid-feedback"><strong>{{ $errors->first('slug') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="descr" class="col-form-label">Descr</label>
            <input id="descr" type="text" class="form-control{{ $errors->has('descr') ? ' is-invalid' : '' }}" name="descr" value="{{ old('descr') }}">
            @if ($errors->has('descr'))
                <span class="invalid-feedback"><strong>{{ $errors->first('descr') }}</strong></span>
            @endif
        </div>


        <div class="form-group">
            <label for="parent" class="col-form-label">Parent</label>
            <select id="parent" class="form-control{{ $errors->has('parent') ? ' is-invalid' : '' }}" name="parent">
                <option value=""></option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}"{{ $parent->id == old('parent') ? ' selected' : '' }}>
                        @for ($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
                        {{ $parent->name_categ }}
                    </option>
                @endforeach;
            </select>
            @if ($errors->has('parent'))
                <span class="invalid-feedback"><strong>{{ $errors->first('parent') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection