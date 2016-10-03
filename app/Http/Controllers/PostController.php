<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\PostPublished;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;

class PostController extends Controller
{

    /**
     * Display a listing of the post.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return view('backend.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->getCategories();
        $tags = $this->getTags();
        return view('backend.post.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created post in database.
     *
     * @param PostRequest $request
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Tag $tag)
    {
        //Get tags id's
        $newTagsId = $tag->storeNewTags($request->tags);
        //Store post
        $post = new Post;
        $post->category_id = $request->category;
        $post->user_id = $request->user()->id;
        $post->title = $request->title;
        $post->body = $request->body;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = Post::imageUpload($request->file('image'));
            $post->image_path = $path;
        }
        $post->save();
        //Store new tags on pivot table
        $post->tags()->attach($newTagsId);

        return back()->with('success', ' Post Created!');
    }

    /**
     * Display the specified post.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        event(new PostPublished($post));
        return view('backend.post.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = $this->getCategories();
        $tags = $this->getTags();
        return view('backend.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post in database.
     *
     * @param PostRequest $request
     * @param Post $post
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post, Tag $tag)
    {
        $this->authorize('update', $post);
        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->user_id = $request->user()->id;
        $post->body = $request->body;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = Post::imageUpload($request->file('image'));
            Storage::delete($this->getImagePath($post->image_path));
            $post->image_path = $path;
        }
        $post->save();

        $tags = $tag->storeNewTags($request->tags);
        $post->tags()->sync($tags);
        return back()->with('success', 'Post Updated.');
    }

    /**
     * Remove the specified post from database.
     *
     * @param \App\Post $post
     * @param Storage $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Storage $storage)
    {
        if ($storage->exists($post->image_path)) {
            $storage->delete($post->image_path);
        }
        $post->delete();
        return back()->with('success', 'Post Removed!');
    }

    /**
     * List of all categories
     *
     * @return array
     */
    private function getCategories()
    {
        return Category::pluck('name', 'id');
    }

    /**
     * List of all tags
     *
     * @return array
     */
    private function getTags()
    {
        return Tag::pluck('name', 'id');
    }

    /**
     * Update visibility of blog post
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVisibility(Request $request)
    {
        abort_unless(($request->ajax() && auth()->user()->isSuperAdmin()), 403);
        $post = Post::findOrFail($request->post_id);
        if ($post->visible) {
            $post->visible = false;
            $data = [
                'message' => 'Post is hidden.',
                'type'    => 'error'
            ];
        }
        else {
            $post->visible = true;
            $post->published_at = Carbon::now();
            $data = [
                'message' => 'Post is published.',
                'type'    => 'success'
            ];
            event(new PostPublished($post));
        }
        $post->save();
        return response()->json($data);
    }

}
