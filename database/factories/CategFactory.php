<?php

use Faker\Generator as Faker;

$factory->define(\App\Entity\Categ::class, function (Faker $faker) {
    return [
        'name_categ' => $name_categ = $faker->text(20),
        'slug' => str_slug($name_categ),
        'descr' => $name_categ = $faker->text(20),
        'parent_id' => null,
    ];
});
