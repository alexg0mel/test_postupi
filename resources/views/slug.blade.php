@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="app">

                    </div>
                        <br><br>

                    <div class="tool-view" style="text-align: right">
                        <span> <i class="fa fa-list fa-2x"></i> </span>
                        <span> <i class="fa fa-table fa-2x"></i> </span>
                    </div>
                    <div class="row list-group">
                        <div class="list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee1</div>
                        <div class="list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee2</div>
                        <div class="list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee3</div>
                        <div class="list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee4</div>
                        <div class="list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee5</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12 list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee1</div>
                        <div class="col-md-4 col-sm-4 col-xs-12 list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee2</div>
                        <div class="col-md-4 col-sm-4 col-xs-12 list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee3</div>
                        <div class="col-md-4 col-sm-4 col-xs-12 list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee4</div>
                        <div class="col-md-4 col-sm-4 col-xs-12 list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee5</div>
                        <div class="col-md-4 col-sm-4 col-xs-12 list-group-item">tttttteeeeeeeeeeeeeeeeeeeeeeee6</div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script src="{{ mix('js/front.js', 'build') }}"></script>

@endsection