<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/login')
            ->type('gaylord.verner@example.org', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/dashboard');
    }
}
