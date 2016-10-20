<?php

namespace App\Repositories;


use App\Post;
use Illuminate\Contracts\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;

class PostRepository extends EloquentRepository
{
    public function __construct(Container $container)
    {
        $this->setContainer($container)
            ->setModel(Post::class)
            ->setRepositoryId('rinvex.repository.uniqueid');
    }
}