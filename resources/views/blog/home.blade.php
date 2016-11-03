@extends('layouts.master')

@section('content')
    @include('partials._scout-search')

    <div class="posts">
        @foreach($posts->chunk(3) as $chunk)
            <div class="row">
                @foreach($chunk as $post)
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <h1><a href="{{ route('blog.post', [$post->slug]) }}">{{ $post->title }}</a></h1>
                        @if($post->image_path)
                            <img src="{{ $post->image_path }}" alt="{{ $post->slug }}" class="img-thumbnail" width="100" height="100">
                        @endif
                        <p>{{ str_limit($post->body, 30) }}</p>
                        <p>{{ $post->visit }} visits. Created By {{ $post->user->name }}</p>
                    </div>
                @endforeach
            </div>
        @endforeach
        {!! $posts->links() !!}
    </div>
@endsection

@stack('vue-scripts')