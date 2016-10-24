<?php

namespace App\Services;


class FooService
{
    /**
     * The BarService instance.
     *
     * @var BarService
     */
    protected $bar;

    /**
     * Create new instance of FooService.
     *
     * @param BarService $bar
     */
    public function __construct(BarService $bar)
    {
        $this->bar = $bar;
    }

    /**
     * Do something useful.
     *
     * @return string
     */
    public function doSomething()
    {
        return $this->bar->somethingToDo();
    }
}