<?php

namespace App\UseCases\Categories;

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



    //select innercateg.name_categ,innercateg.slug, innercateg.id, innercateg.parent_id, count(comments.id) as countcomments from categs as root
    //inner join categs as innercateg on (innercateg._lft between root._lft and root._rgt)
    //left join news on (innercateg.id = news.categ_id)
    //left join comments on (news.id = comments.news_id)
    //where root.parent_id = 221  and comments.published=true
    //group by innercateg.name_categ, innercateg.slug, innercateg.id, innercateg.parent_id
    //
    //and then need compact for root of innercateg

    public function getCategWithCountComments(int $parent_id)
    {

        $query = DB::table('categs as root')->select(DB::raw('innercateg.name_categ,innercateg.slug, innercateg.id, innercateg.parent_id, count(comments.id) as countcomments'))
            ->join('categs as innercateg', function ($join) {
                $join->on('innercateg._lft','>=','root._lft')
                    ->on('innercateg._lft','<=','root._rgt');
            })
            ->leftJoin('news', 'innercateg.id', '=', 'news.categ_id')
            ->leftJoin('comments', 'news.id', '=', 'comments.news_id')
            ->where(['root.parent_id'=>$parent_id,'comments.published'=>true])
            ->groupBy(['innercateg.name_categ', 'innercateg.slug', 'innercateg.id', 'innercateg.parent_id'])
            ->get();


        while (true) {
            if ($this->needCompact($query, $parent_id))
                $this->compact($query, $parent_id); else break;
        }

        $res = [];
        foreach ($query as $item){
            if ($item->parent_id == $parent_id){
                $newitem = new \stdClass();
                $newitem->name_categ = $item->name_categ;
                $newitem->slug = $item->slug;
                $newitem->countcomments = $item->countcomments;
               $res[] = $newitem;
            }
        }

        return$res;

    }


    //select news.id,news.name_news,news.slug, news.body_news, count(comments.id) as countcomments from categs
    //left join news on (categs.id = news.categ_id)
    //left join comments on (news.id = comments.news_id)
    //where categs.id = 221  and comments.published=true
    //group by news.id,news.name_news,news.slug, news.body_news

    public function getListNewsWithCountComments(int $categ_id)
    {
            $query = DB::table('categs')->select(DB::raw('news.id,news.name_news,news.slug, news.body_news, count(comments.id) as countcomments'))
            ->leftJoin('news', 'categs.id', '=', 'news.categ_id')
            ->leftJoin('comments', 'news.id', '=', 'comments.news_id')
            ->where(['categs.id'=>$categ_id,'comments.published'=>true])
            ->groupBy(['news.id','news.name_news','news.slug', 'news.body_news'])
            ->get();

            foreach ($query as &$item){
                $item->path = 'path';
            }

            return $query;
    }

    private function needCompact($query, $parent_id):bool
    {
        $need = false;
        foreach ($query as $item){
            if ($item->parent_id != $parent_id && $item->countcomments > 0) {
                $need = true;
                break;
            }
        }
        return $need;
    }

    private function compact(&$query, $parent_id):void
    {
        foreach ($query as $item){
            if ($item->parent_id != $parent_id && $item->countcomments > 0) {
                foreach ($query as $parent){
                    if($item->parent_id == $parent->id){
                        $parent->countcomments += $item->countcomments;
                        $item->countcomments = 0;
                    }
                }

            }
        }
    }



}