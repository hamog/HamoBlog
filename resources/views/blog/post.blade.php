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
        <em>Tags:</em>
        @forelse($post->tags as $tag)
            {{ $tag->name }}{{ ($loop->remaining) ? ',' : '' }}
        @empty
            No Tags.
        @endforelse
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
            </div>
        @empty
            No Comments.
        @endforelse
    </div>

    @include('partials._errors-box')

    {!! Form::open(['route' => ['comment.store', $post->id], 'method' => 'post']) !!}
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

    <button type="submit" class="btn btn-primary">Send</button>
    {!! Form::close() !!}
@endsection
