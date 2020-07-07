<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'body' => rtrim($faker->paragraphs(rand(3,7),true)),
        'user_id'=> App\User::all('id')->random(),
    ];
});
