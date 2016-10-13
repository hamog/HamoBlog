@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-header">Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Categories</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
                            <a href="{{ route('category.index') }}">Category Lists</a>
                            <span class="badge pull-right">{{ $catsCount }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @if(Auth::user()->is_admin)
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Users</h3>
                        </div>
                        <div class="panel-body">
                            <p>
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <a href="{{ route('user.lists') }}">Users Lists</a>
                                <span class="badge pull-right">{{ $usersCount }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-3">
                <div class="panel panel-info">
                	  <div class="panel-heading">
                			<h3 class="panel-title">Posts</h3>
                	  </div>
                	  <div class="panel-body">
                          <p>
                              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                              <a href="{{ route('post.index') }}">Posts Lists</a>
                              <span class="badge pull-right">{{ $postsCount }}</span>
                          </p>
                	  </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tags</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                            <a href="{{ route('tag.index') }}">Tag Lists</a>
                            <span class="badge pull-right">{{ $tagsCount }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Comments</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                            <a href="{{ route('comment.index') }}">Comment Lists</a>
                            <span class="badge pull-right">{{ $commentsCount }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection