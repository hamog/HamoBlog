@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                </div>
@foreach($posts as $post)
    <h1>{{ $post->title }}</h1>
    <div>
        <img src="{{ Storage::url($post->photo) }}">
        {{ $post->body }}
    </div>
@endforeach
            </div>
        </div>
    </div>
</div>
@endsection
