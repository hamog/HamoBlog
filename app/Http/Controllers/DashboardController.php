<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;

class DashboardController extends Controller
{
    /**
     * Counting the number of categories.
     *
     * @var integer
     */
    protected $catsCount;

    /**
     * Counting the number of users.
     *
     * @var integer
     */
    protected $usersCount;

    /**
     * Counting the number of posts.
     *
     * @var integer
     */
    protected $postsCount;

    /**
     * Counting the number of tags.
     *
     * @var integer
     */
    protected $tagsCount;

    /**
     * Counting the number of comments.
     *
     * @var integer
     */
    protected $commentsCount;

    public function __construct(
        CategoryRepository $category,
        UserRepository $user,
        PostRepository $post,
        TagRepository $tag,
        CommentRepository $comment
    )
    {
        $this->catsCount = cache()->rememberForever('catsCount', function () use($category) {
            return $category->count();
        });
        $this->usersCount = cache()->rememberForever('usersCount', function () use($user) {
            return $user->count();
        });
        $this->postsCount = cache()->rememberForever('postsCount', function () use($post) {
            return $post->withoutGlobalScope('visible')->count();
        });
        $this->tagsCount = cache()->rememberForever('postsCount', function () use($tag) {
            return $tag->count();
        });
        $this->commentsCount = cache()->rememberForever('commentsCount', function () use($comment) {
            return $comment->withoutGlobalScope('confirmed')->count();
        });
    }
    /**
     * Showing dashboard panel
     */
    public function dashboard()
    {
        return view('backend.dashboard')->with([
            'catsCount'     => $this->catsCount,
            'usersCount'    => $this->usersCount,
            'postsCount'    => $this->postsCount,
            'tagsCount'     => $this->tagsCount,
            'commentsCount' => $this->commentsCount
        ]);
    }
}
