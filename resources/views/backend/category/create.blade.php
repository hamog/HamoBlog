@extends('layouts.master')

@section('content')
    <h1 class="page-header">Create New Category</h1>
    @include('partials._errors-box')
    @include('partials._notifications')
    {!! Form::open(['route' => 'category.store']) !!}
    @include('backend.category._form')
    {!! Form::submit('Create Category', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    <div class="text-center">
        <a href="{{ route('category.index') }}" class="btn btn-default">Back to Category</a>
    </div>
@endsection
