@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<h1 class="page-header">Lists of all users</h1>
                @include('partials._notifications')
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
                                        <button type="submit" class="btn btn-danger btn-sm" id="delete-user">
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

@section('js')
    <script>
        $("button#delete-user").click(function (event) {
            event.preventDefault()
            var form = $(this).parents('form');
            swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this user!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function(isConfirm) {
                        if (isConfirm) form.submit();
                        swal("Deleted!", "The user has been deleted.", "success");
                    });
        })
    </script>
@endsection