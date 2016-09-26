@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">Change Password</h1>
                @include('partials._errors-box')
                @include('partials._notifications')
                {!! Form::open(['route' => ['user.password.update', auth()->user()->id], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('old_password', 'Old Password', ['class' => 'control-label']) !!}
                    {!! Form::password('old_password', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'control-label']) !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit('Change Password', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection