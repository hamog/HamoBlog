@extends('layouts.master')

@section('content')
    <h1 class="page-header">Create New Post</h1>
    @include('partials._errors-box')
    @include('partials._notifications')
    {!! Form::open(['route' => 'post.store', 'files' => true]) !!}
    @include('backend.post._form')
    {!! Form::submit('Create Post', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <div class="text-center">
        <a href="{{ route('post.index') }}" class="btn btn-default">Back to Post</a>
    </div>
@endsection

@section('js')
    <script>
        $("#tags").select2({
            tags: true
        });
    </script>
@endsection