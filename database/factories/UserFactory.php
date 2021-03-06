<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
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
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'photo' => "logo.png",
        'email_verified_at' => now(),
        'password' => '$2y$10$2m6.4aNBqHJF3seT9ZS4TujW.a2jI5a/3CO9v6v1T4u2X908P7zxC', // password
        'remember_token' => Str::random(10),
    ];
});
