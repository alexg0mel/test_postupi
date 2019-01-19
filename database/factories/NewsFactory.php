<?php

use Faker\Generator as Faker;

$factory->define(\App\Entity\News::class, function (Faker $faker) {
    return [
        'name_news' => $name_news = $faker->text(20),
        'slug' => str_slug($name_news),
        'body_news' => $faker->text(70),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
