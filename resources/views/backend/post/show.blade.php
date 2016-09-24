@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">{{ $post->title }}</h1>
                <div>
                    <img src="{{ $post->image_path }}" alt="{{ $post->slug }}" class="img-responsive">
                </div>
                <p>{{ $post->body }}</p>
                <p>Created By <strong>{{ $post->user->name }}</strong> on {{ $post->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
@endsection