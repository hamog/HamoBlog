<?php

namespace App\Repositories;

use App\User;
use Illuminate\Contracts\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;

class UserRepository extends EloquentRepository
{
    public function __construct(Container $container)
    {
        $this->setContainer($container)
            ->setModel(User::class)
            ->setRepositoryId('rinvex.repository.uniqueid');
    }
}