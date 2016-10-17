<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the comment.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $comments = Comment::withoutGlobalScope('confirmed')->with('post')->paginate();
        return view('backend.comment.index', compact('comments'));
    }
    /**
     * Store comment of post.
     *
     * @param CommentRequest $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create($request->all());
        $comment->ip = $request->ip();
        $comment->user_agent = $request->header('User-Agent');
        $comment->save();

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

    /**
     * Remove the specified comment from database.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        alert()->success('Comment Removed', 'The comment is permanently removed.');
        return redirect()->route('comment.index');
    }
}
