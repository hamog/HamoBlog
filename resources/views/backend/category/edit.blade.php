@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">Edit Category</h1>
                {!! Form::model($category, ['route' => ['category.update', $category->id], 'method' => 'put']) !!}
                @include('backend.category._form')
                {!! Form::submit('Update Category', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection