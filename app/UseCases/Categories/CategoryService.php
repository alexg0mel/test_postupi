<?php

namespace App\UseCases\Categories;

use App\Entity\Categ;
use DB;

class CategoryService
{

    public function getRootCategWithCountNews()
    {
        //select root.name_categ,root.slug,count(news.id) as countnews from categs as root
        //inner join categs as innercateg on (innercateg._lft between root._lft and root._rgt)
        //left join news on (innercateg.id = news.categ_id)
        //where root.parent_id is null
        //group by root.name_categ,root.slug

        return DB::table('categs as root')->select(DB::raw('root.name_categ, root.slug, count(news.id) as countnews'))
            ->joinWhere('categs as innercateg', DB::raw('true'),DB::raw('innercateg._lft between root._lft and root._rgt'), '')
            ->leftJoin('news', 'innercateg.id', '=', 'news.categ_id')
            ->where(['root.parent_id'=>null])
            ->groupBy(['root.name_categ', 'root.slug'])
            ->get();
    }



}