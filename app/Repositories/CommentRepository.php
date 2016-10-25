<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Contracts\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;

class CommentRepository extends EloquentRepository
{
    public function __construct(Container $container)
    {
        $this->setContainer($container)
            ->setModel(Comment::class)
            ->setRepositoryId('rinvex.repository.102');
    }
}