<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store comment of post.
     *
     * @param CommentRequest $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentRequest $request, Post $post)
    {
        $post->comments()->create($request->all());

        alert()->success('Thank you.', 'Your comment stored and after confirm will display.');
        return back();
    }

    /**
     * Reply a comment of post.
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(Request $request, Comment $comment)
    {
        //Authorization
        $this->authorize('update', $comment);
        //Validation
        $this->validate($request, ['reply' => 'required|max:1000']);
        //Update
        $comment->reply = $request->reply;
        $comment->save();
        //Set flash message and response
        alert()->success('Replied', 'The comment is replied.');
        return back();
    }

    /**
     * Confirmation of comments.
     *
     * @param Request $request
     */
    public function confirm(Request $request)
    {
        //
    }
}
