<?php

use App\Entity\Categ;
use Illuminate\Database\Seeder;

class CategsTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(Categ::class, 10)->create()->each(function(Categ $category) {
            $max_news=random_int(1,5);
            for ($i=0; $i <= $max_news; $i++ )
                $category->news()->save(factory(\App\Entity\News::class)->make());
            $counts = [0, random_int(3, 10)];
            $category->children()->saveMany(factory(Categ::class, $counts[array_rand($counts)])->create()->each(function(Categ $category) {
                $max_news=random_int(1,5);
                for ($i=0; $i <= $max_news; $i++ )
                    $category->news()->save(factory(\App\Entity\News::class)->make());
                $counts = [0, random_int(3, 10)];
                $category->children()->saveMany(factory(Categ::class, $counts[array_rand($counts)])->create())->each(function (Categ $category) {
                    $max_news=random_int(1,5);
                    for ($i=0; $i <= $max_news; $i++ )
                        $category->news()->save(factory(\App\Entity\News::class)->make());

                });
            }));
        });
    }
}
