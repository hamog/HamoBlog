@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-header">Tag lists</h1>
        @include('partials._notifications')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="table-responsive">
            		<table class="table table-hover">
            			<thead>
                        <tr>
                            <th>#</th>
                            <th>Tag Name</th>
                            <th>Operations</th>
                        </tr>
            			</thead>
            			<tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>
                                        <a href="{{ route('tag.edit', [$tag->id]) }}">
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                        {!! Form::open([
                                                'route' => ['tag.destroy', $tag->id],
                                                'method' => 'delete',
                                                'style' => 'display:inline'
                                            ]) !!}
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
            			</tbody>
            		</table>
                    {{ $tags->links() }}
            	</div>
            </div>
        </div>
    </div>
@endsection