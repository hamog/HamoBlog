<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

//    /**
//     * Authorize all actions within a comment policy.
//     *
//     * @param $user
//     * @param $ability
//     * @return bool
//     */
//    public function before($user, $ability)
//    {
//        if ($user->isSuperAdmin()) {
//            return true;
//        }
//    }

    /**
     * Determine whether the user can view the comment.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function view(User $user, Comment $comment)
    {
        //
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the comment.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->post->user_id;
    }

    /**
     * Determine whether the user can delete the comment.
     *
     * @param  App\User  $user
     * @param  App\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        //
    }
}
