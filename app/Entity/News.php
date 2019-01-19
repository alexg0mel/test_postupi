<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\News
 *
 * @property int $id
 * @property string $name_news
 * @property string $slug
 * @property string $body_news
 * @property int $categ_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\News query()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Comment[] $comments
 */
class News extends Model
{
    protected $fillable = ['name_news', 'slug','body_news', 'categ_id'];


    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id', 'id');
    }
}
