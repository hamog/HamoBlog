<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Cache;

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

    public function __construct(
        Category $category,
        User $user,
        Post $post,
        Tag $tag
    )
    {
        $this->catsCount = Cache::remember('catsCount', 60*24, function () use($category) {
            return $category->count();
        });
        $this->usersCount = Cache::remember('usersCount', 60*24, function () use($user) {
            return $user->count();
        });
        $this->postsCount = Cache::remember('postsCount', 60*24, function () use($post) {
            return $post->count();
        });
        $this->tagsCount = Cache::remember('tagsCount', 60*24, function () use($tag) {
            return $tag->count();
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
        ]);
    }
}
