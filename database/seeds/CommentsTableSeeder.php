<?php

use App\Entity\Categ;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $news = \App\Entity\News::all();
        foreach ($news as $item_news) {
            $max=random_int(0,4);
            for ($i=0; $i <= $max; $i++ )
                $item_news->comments()->save(factory(\App\Entity\Comment::class)->make());
        }

    }

}
