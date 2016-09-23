@extends('layouts.master')

@section('styles')
    <style>
        .tags {
            list-style: none;
        }
        .tags li {
            display: inline;
        }
    </style>
@endsection

@section('content')
    <h1>Bootstrap starter template</h1>
    <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a
        mostly barebones HTML document.</p>
    @foreach($posts->chunk(2) as $chunk)
        <div class="row">
            @foreach($chunk as $post)
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <h1><a href="{{ url("post/detail/{$post->slug}") }}">{{ $post->title }}</a></h1>
                    <p>{{ str_limit($post->body, 30) }}</p>
                    <p>Posted by {{ $post->user->name }} On {{ $post->created_at->format('F d , Y') }}</p>
                    <ul class="tags">
                        @foreach($post->tags as $tag)
                            <li><a href="{{ url("posts/tag/{$tag->id}") }}">#{{ $tag->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
