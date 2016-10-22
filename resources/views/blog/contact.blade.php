@extends('layouts.master')

@section('content')
    <h1 class="page-header">Contact Me</h1>

    @include('partials._errors-box')

    {!! Form::open(['route' => 'send.contact']) !!}

    <legend>Please sending your messages from below form :</legend>

    <div class="form-group">
        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! captcha_img() !!}
        {!! Form::text('captcha', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group text-center">
        {!! Form::submit('Send Message', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection

