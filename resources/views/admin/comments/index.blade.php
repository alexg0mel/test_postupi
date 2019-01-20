@extends('layouts.app')

@section('content')
    @include('admin.comments._nav')


    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Author</th>
            <th>Comment</th>
            <th>News</th>
            <th></th>


        </tr>
        </thead>
        <tbody>

        @foreach ($comments as $comment)
            <tr data-comment="{{ $comment->id }}">
                <td>{{ $comment->author }}</td>
                <td>{{ $comment->body_comment }}</td>
                <td>{{ $comment->news->name_news }}</td>
                <td>
                    <button type="button" class="btn btn-success cmd_publish">Опубликовать</button>
                    <button type="button" class="btn btn-danger cmd_delete">Удалить</button>
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>
@endsection


@section('script')
    <script>
        const api_token = { headers: { 'Authorization': 'Bearer ' + '{!! $token !!}' } };
        window.onload = function() {
            $('.cmd_publish').on('click',function () {
                let tr =$(this).closest('tr');
                axios.post('/api/comment/'+tr.data('comment')+'/publish',{},api_token).then((response) => {
                    tr.remove();
                });
            });
            $('.cmd_delete').on('click',function () {
                let tr =$(this).closest('tr');
                axios.delete('/api/comment/'+tr.data('comment')+'/publish',api_token).then((response) => {
                    tr.remove();
                });
            });


        };

    </script>
@endsection