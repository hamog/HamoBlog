<?php

namespace App\Http\Controllers;

use App\Category;
use App\Events\PostPublished;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Repositories\PostRepository;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem as Storage;

class PostController extends Controller
{

    /**
     * Display a listing of the post.
     *
     * @param PostRepository $postRepository
     * @return \Illuminate\Http\Response
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->with(['category'])->orderBy('created_at', 'desc')->paginate(10);
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
        $post->body = clean($request->body);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = Post::imageUpload($request->file('image'));
            $post->image_path = $path;
        }
        $post->save();
        //Store new tags on pivot table
        $post->tags()->attach($newTagsId);

        alert()->success('Success', 'Post Created.');
        return redirect()->route('post.index');
    }

    /**
     * Display the specified post.
     *
     * @param integer $id
     * @param PostRepository $postRepository
     * @return \Illuminate\Http\Response
     */
    public function show($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        return view('backend.post.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param integer $id
     * @param PostRepository $postRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        $categories = $this->getCategories();
        $tags = $this->getTags();
        return view('backend.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post in database.
     *
     * @param integer $id
     * @param PostRequest $request
     * @param PostRepository $postRepository
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update($id, PostRequest $request, PostRepository $postRepository, Tag $tag)
    {
        $post = $postRepository->find($id);
        $this->authorize('update', $post);
        $data = [
            'title'         => $request->title,
            'category_id'   => $request->category,
            'user_id'       => $request->user()->id,
            'body'          => $request->body,
        ];
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = Post::imageUpload($request->file('image'));
            Storage::delete($post->image_path);
            $data = array_add($data, 'image_path', $path);
        }
        $postRepository->update($id, $data);

        $tags = $tag->storeNewTags($request->tags);
        $post->tags()->sync($tags);
        alert()->success('Success', 'Post Updated.');
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified post from database.
     *
     * @param integer $id
     * @param PostRepository $postRepository
     * @param Storage $storage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PostRepository $postRepository, Storage $storage)
    {
        $post = $postRepository->find($id);
        if ($storage->exists($post->image_path)) {
            $storage->delete($post->image_path);
        }
        $postRepository->delete($id);
        alert()->success('Success', 'Post Removed.');
        return back();
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
