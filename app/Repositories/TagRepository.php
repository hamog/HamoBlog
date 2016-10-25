<?php

namespace App\Repositories;

use App\Tag;
use Illuminate\Contracts\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;

class TagRepository extends EloquentRepository
{
    public function __construct(Container $container)
    {
        $this->setContainer($container)
            ->setModel(Tag::class)
            ->setRepositoryId('rinvex.repository.104');
    }
}