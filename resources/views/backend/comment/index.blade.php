@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-header">Comments lists</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="table-responsive">
            		<table class="table table-hover">
            			<thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Comment</th>
                            <th>Confirmation</th>
                            <th>Reply</th>
                            <th>Operations</th>
                        </tr>
            			</thead>
            			<tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->name }}</td>
                                    <td>{{ $comment->email }}</td>
                                    <td>{{ $comment->comment }}</td>
                                    <td>
                                        <input type="checkbox" id="comment-confirmation" @if($comment->confirmed) checked @endif>
                                    </td>
                                    <td id="reply">
                                        @if($comment->reply)
                                            {{ $comment->reply }}
                                        @else
                                            <input type="text" class="reply-comment" data-url="{{ route('comment.ajax.reply', [$comment->id]) }}">
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::open([
                                                'route' => ['comment.destroy', $comment->id],
                                                'method' => 'delete',
                                                'style' => 'display:inline'
                                            ]) !!}
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
            			</tbody>
            		</table>
                    {{ $comments->links() }}
            	</div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (function () {
            $(".reply-comment").change(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).data('url'),
                    method: 'PATCH',
                    data: {
                        reply: $(this).val()
                    },
                    success: function (res) {
                        console.log(res.reply);
                    },
                    error: function (err) {
                        var errors = err.responseJSON;
                        console.log(errors);
                    }
                });
            });
        })();
    </script>
@endsection