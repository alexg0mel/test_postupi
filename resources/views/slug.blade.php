@extends('layouts.app')

@section('content')
    <div id="app">

    </div>
@endsection


@section('script')
    <script>
        window.currid = "{{ $curr_id }}";
        window.slug =  "{{ $slug }}";
        window.isnews =  "{{ $is_news }}"
    </script>
    <script src="{{ mix('js/front.js', 'build') }}"></script>
@endsection
