<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Comment
 *
 * @property int $id
 * @property string $author
 * @property string $body_comment
 * @property int $news_id
 * @property boolean $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Comment query()
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $fillable = ['author', 'body_comment', 'news_id'];
}
