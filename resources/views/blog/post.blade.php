@extends('layouts.master')

@section('content')
    <h1 class="page-header">{{ $post->title }}</h1>
    <div>
        @if($post->image_path)
            <img src="{{ $post->image_path }}" alt="{{ $post->title }}">
        @endif
    </div>
    <p>{{ $post->body }}</p>
    <p>Created By <strong>{{ $post->user->name }}</strong> On {{ $post->created_at->format('d F Y') }}</p>
    <div class="tags">
        <ul class="nav nav-pills">
            @foreach($post->tags as $tag)
                <li class="active"><a href="#">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <p></p>
    <div>
        Share with:
        @inject('social', 'App\Services\SocialShare')
        {!! $social->make('twitter') !!}
        {!! $social->make('facebook') !!}
        {!! $social->make('telegram') !!}
        {!! $social->make('google') !!}
    </div>
    <div class="comments">
        <em>Comments:</em>
        @forelse($post->comments as $comment)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>{{ $comment->name }} Says: <span class="pull-right">{{ $comment->created_at->format('F d, Y \\a\\t H:i A') }}</span></p>
                </div>
                <div class="panel-body">
                    {{ $comment->comment }}
                </div>

                @if($comment->reply)
                    <div class="panel-footer">
                        <p class="text-info"><b>{{ $post->user->name }} :</b> {{ $comment->reply }}</p>
                    </div>
                @else
                    @can('update', $post)
                        <div class="panel-footer">
                            <h3>Reply to this Comment</h3>
                            <div id="reply-comment">
                                {!! Form::open(['route' => ['comment.reply', $comment->id], 'method' => 'patch']) !!}

                                <div class="form-group">
                                    {!! Form::label('reply', 'Reply', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('reply', null, ['class' => 'form-control']) !!}
                                </div>

                                <button type="submit" class="btn btn-primary">Send</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endcan
                @endif

            </div>
        @empty
            No Comments.
        @endforelse
    </div>

    @include('partials._errors-box')

    {!! Form::open(['route' => ['comment.store', $post->id], 'method' => 'post', 'id' => 'comment-reply']) !!}
    <legend>Please enter your comment with below form:</legend>
    <p>Your email address will not be published.</p>

    <div class="form-group">
        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('comment', 'Comment', ['class' => 'control-label']) !!}
        {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('captcha', 'Security Code', ['class' => 'control-label']) !!}
        {!! captcha_img() !!}
        {!! Form::text('captcha', null, ['class' => 'form-control']) !!}
    </div>

    <button type="submit" class="btn btn-primary">Send</button>
    {!! Form::close() !!}
@endsection

