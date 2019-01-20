@extends('layouts.app')

@section('content')
    @include ('admin._nav', ['page' => ''])

    <p> Admin zone. This application is a test task. </p>
@endsection


@section('aut')
    @include('_aut')
@endsection