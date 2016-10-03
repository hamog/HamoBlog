@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-header">post lists</h1>
        <div>
            <a href="{{ route('post.create') }}" class="btn btn-primary btn-lg">New Post</a>
        </div>
        @include('partials._notifications')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="table-responsive">
            		<table class="table table-hover">
            			<thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Visible</th>
                            <th>Image</th>
                            <th>Operations</th>
                        </tr>
            			</thead>
            			<tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td><a href="{{ route('post.show', [$post->id]) }}">{{ $post->title }}</a></td>
                                    <td><a href="{{ route('category.show', [$post->category->id]) }}">{{ $post->category->name }}</a></td>
                                    <td>
                                        <input type="checkbox" class="visibility" data-id="{{ $post->id }}" @if($post->visible) checked @endif @unless(auth()->user()->isSuperAdmin()) disabled @endunless>
                                    </td>
                                    <td>
                                        @if($post->image_path)
                                            <img src="{{ $post->image_path }}" alt="{{ $post->slug }}" width="150" height="100" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('post.edit', [$post->id]) }}">
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                        {!! Form::open([
                                                'route'     => ['post.destroy', $post->id],
                                                'method'    => 'delete',
                                                'style'     => 'display:inline',
                                            ]) !!}
                                        <button type="submit" class="btn btn-danger btn-sm" id="delete-post">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
            			</tbody>
            		</table>
                    {{ $posts->links() }}
            	</div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(".visibility").change(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('post.visible') }}',
                type: 'PATCH',
                dataType: 'json',
                data: {post_id: $(this).data('id')},
                success: function (res) {
                    swal(res.message, "You clicked the button!", res.type);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        })
    </script>
    <script>
        $("button#delete-post").click(function (event) {
            event.preventDefault()
            var form = $(this).parents('form');
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this post!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                },
                function(isConfirm) {
                    if (isConfirm) form.submit();
                    swal("Deleted!", "The post has been deleted.", "success");
                });
        })
    </script>
@endsection