@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">Edit Profile</h1>
                @include('partials._notifications')
                @include('partials._errors-box')
                {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'patch']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit('Update Profile', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection