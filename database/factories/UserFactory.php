<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'), // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(\App\Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'director' => $faker->name,
        'imageUrl' => $faker->url,
        'duration' => $faker->numberBetween(0, 200),
        'releaseDate' => $faker->dateTime,
        'genre' => $faker->name
    ];
});
