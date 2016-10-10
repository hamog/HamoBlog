<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Post;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Post $post)
    {
        $post->comments()->create($request->all());
        alert()->success('Thank you.', 'Your comment stored and after confirm will display.');
        return back();
    }
}
