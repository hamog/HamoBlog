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
    <p>
        Tags:
        @foreach($post->tags as $tag)
            {{ $tag->name }}@unless($loop->last), @endunless
        @endforeach
    </p>
@endsection
