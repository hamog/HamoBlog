<?php

namespace App\Repositories;

use App\Category;
use Illuminate\Contracts\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;

class CategoryRepository extends EloquentRepository
{
    public function __construct(Container $container)
    {
        $this->setContainer($container)
            ->setModel(Category::class)
            ->setRepositoryId('rinvex.repository.101');
    }
}