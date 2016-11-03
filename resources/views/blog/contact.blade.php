@extends('layouts.master')

@section('styles')
    <!-- add csrf token -->
    <meta id="token" name="token" value="{{ csrf_token() }}">
@endsection

@section('content')
    <h1 class="page-header">Contact Me</h1>

    @include('partials._errors-box')
    <div class="alert alert-success" v-if="submitted">
        Your message is sent.
    </div>

    {!! Form::open(['route' => 'send.contact', '@submit.prevent' => 'createContact']) !!}

    <legend>Please sending your messages from below form :</legend>

    <div class="form-group@{{ errors.name ? ' has-error' : '' }}">
        {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'v-model' => 'contact.name']) !!}
        {{-- display errors if field has errors using FormError component --}}
        <form-error v-if="errors.name" :errors="errors">
            @{{ errors.name }}
        </form-error>
    </div>

    <div class="form-group@{{ errors.email ? ' has-error' : '' }}">
        {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
        {!! Form::email('email', old('email'), ['class' => 'form-control', 'v-model' => 'contact.email']) !!}
        {{-- display errors if field has errors using FormError component --}}
        <form-error v-if="errors.email" :errors="errors">
            @{{ errors.email }}
        </form-error>
    </div>
    <div class="form-group@{{ errors.message ? ' has-error' : '' }}">
        {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
        {!! Form::textarea('message', old('message'), ['class' => 'form-control', 'v-model' => 'contact.message']) !!}
        {{-- display errors if field has errors using FormError component --}}
        <form-error v-if="errors.message" :errors="errors">
            @{{ errors.message }}
        </form-error>
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

@section('js')
    <script src="{{ asset('js/contact.js') }}"></script>
@endsection

