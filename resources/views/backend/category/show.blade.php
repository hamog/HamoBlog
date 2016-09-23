@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="page-header">{{ $category->name }}</h1>
            </div>
        </div>
    </div>
@endsection