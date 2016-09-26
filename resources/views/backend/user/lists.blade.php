@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<h1 class="page-header">Lists of all users</h1>
                <div class="table-responsive">
                	<table class="table table-hover">
                		<thead>
                			<tr>
                				<th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Operations</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {!! Form::open([
                                                'route' => ['user.destroy', $user->id],
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection