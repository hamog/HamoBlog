@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">Edit Tag</h1>
                @include('partials._notifications')
                @include('partials._errors-box')
                {!! Form::model($tag, [
                    'route'     => ['tag.update', $tag->id],
                     'method'   => 'put',
                ]) !!}
                @include('backend.tag._form')
                {!! Form::submit('Update Tag', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $("#tags").select2({
            'tags': true
        });
    </script>
@endsection