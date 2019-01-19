<?php

use Faker\Generator as Faker;

$factory->define(\App\Entity\Comment::class, function (Faker $faker) {
    return [
        'author' => $faker->firstName,
        'body_comment' => $faker->text(70),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
        'published' => $faker->boolean,
    ];
});
