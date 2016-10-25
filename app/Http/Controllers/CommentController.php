<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Clear category count cache.
     *
     * @return void
     */
    private function clearCache()
    {
        if (cache()->has('commentsCount')) {
            cache()->forget('commentsCount');
        }
    }

    /**
     * Display a listing of the comment.
     *
     * @param Comment $comment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Comment $comment)
    {
        $comments = $comment->withoutGlobalScope('confirmed')->with(['post'])->paginate(10);
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

        $this->clearCache();
        alert()->success('Thank you.', 'Your comment stored and after confirm will display.');
        return back();
    }

    /**
     * Reply a comment of post.
     *
     * @param $id
     * @param Request $request
     * @param CommentRepository $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply($id, Request $request, CommentRepository $comment)
    {
        //Authorization
        $this->authorize('update', $comment);
        //Validation
        $this->validate($request, ['reply' => 'required|max:1000']);
        //Update
        $comment->update($id, ['reply' => $request->reply]);
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
     * @param integer $id
     * @param CommentRepository $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, CommentRepository $comment)
    {
        //Delete comment
        $comment->delete($id);
        //Delete cache
        $this->clearCache();
        alert()->success('Comment Removed', 'The comment is permanently removed.');
        return redirect()->route('comment.index');
    }
}
