@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-header">Category lists</h1>
        <div>
            <a href="{{ route('category.create') }}" class="btn btn-primary btn-lg">New Category</a>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="table-responsive">
            		<table class="table table-hover">
            			<thead>
            				<tr>
            					<th>#</th>
                                <th>Name</th>
                                <th>Operations</th>
            				</tr>
            			</thead>
            			<tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>
                                        <a href="{{ route('category.show', [$category->id]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('category.edit', [$category->id]) }}">
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                            </button>
                                        </a>
                                        {!! Form::open([
                                                'route' => ['category.destroy', $category->id],
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
                    {!! $categories->links() !!}
            	</div>
            </div>
        </div>
    </div>
@endsection