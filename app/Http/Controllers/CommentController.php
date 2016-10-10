<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Post $post)
    {
        $post->comments()->create($request->all());
        alert()->success('Thank you.', 'Your comment stored and after confirm will display.');
        return back();
    }

    public function reply(Request $request, Comment $comment)
    {
        $this->validate($request, ['reply' => 'required|max:1000']);
        $comment->reply = $request->reply;
        $comment->save();
        alert()->success('Replied', 'The comment is replied.');
        return back();
    }

    public function confirm(Request $request)
    {
        //
    }
}
