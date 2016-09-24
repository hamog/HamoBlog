<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'category_id'   => \App\Category::inRandomOrder()->first()->id,
        'user_id'       => \App\User::inRandomOrder()->first()->id,
        'title'         => $faker->sentence(),
        'body'          => $faker->paragraph(2),
        'image_path'    => 'http://loremflickr.com/400/300?random='.rand(1, 100),
    ];
});


