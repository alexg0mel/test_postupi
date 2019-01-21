<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Entity\Categ
 *
 * @property int $id
 * @property string $name_categ
 * @property string $slug
 * @property string $descr
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Categ[] $children
 * @property-read \App\Entity\Categ $parent
 * @property-write mixed $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Categ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Categ newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Categ query()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\News[] $news
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Categ whereRoot()
 */
class Categ extends Model
{
    use NodeTrait;

    public $timestamps = false;

    protected $fillable = ['name_categ', 'slug', 'descr', 'parent_id'];


    public function news()
    {
        return $this->hasMany(News::class, 'categ_id', 'id');
    }

    public function scopeWhereRoot(Builder $builder)
    {
        return $builder->where(['parent_id'=>null]);
    }

}
