@extends('layouts.master')

@section('content')
    <div class="well well-sm">
        <div class="form-group">
            <div class="input-group input-group-md">
                <div class="icon-addon addon-md">
                    <input type="text" placeholder="What are you looking for?" class="form-control" v-model="query">
                </div>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" @click="search()" v-if="!loading">Search!</button>
                    <button class="btn btn-default" type="button" disabled="disabled" v-if="loading">Searching...</button>
                </span>
            </div>
        </div>
    </div>
    <div class="alert alert-danger" role="alert" v-if="error">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        @{{ error }}
    </div>
    <div id="posts" class="row list-group">
        <div class="item col-xs-4 col-lg-4" v-for="post in posts">
            <div class="thumbnail">
                <img class="group list-group-image img-thumbnail" width="100" height="100" :src="post.image_path" alt="@{{ post.title }}" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading"><a href="/blog/@{{ post.slug }}">@{{ post.title }}</a></h4>
                    <p class="group inner list-group-item-text">@{{ post.body }}</p>
                    <p>@{{ post.visit }} visits.</p>
                </div>
            </div>
        </div>
    </div>
    <h1>Bootstrap starter template</h1>
    <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a
        mostly barebones HTML document.</p>
    @foreach($posts->chunk(3) as $chunk)
        <div class="row">
            @foreach($chunk as $post)
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <h1><a href="{{ route('blog.post', [$post->slug]) }}">{{ $post->title }}</a></h1>
                    @if($post->image_path)
                        <img src="{{ $post->image_path }}" alt="{{ $post->slug }}" class="img-thumbnail" width="100" height="100">
                    @endif
                    <p>{{ str_limit($post->body, 30) }}</p>
                    <p>{{ $post->visit }} visits</p>
                </div>
            @endforeach
        </div>
    @endforeach
    {!! $posts->links() !!}
@endsection
