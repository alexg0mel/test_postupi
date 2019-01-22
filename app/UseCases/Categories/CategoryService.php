<?php

namespace App\UseCases\Categories;

use App\Entity\News;
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
    // тоже самое  как и внизу - довыбрать категории где нет комментариев в объявлениях
    //
    //select innercateg.name_categ,innercateg.slug, innercateg.id, innercateg.parent_id from categs as root
    //inner join categs as innercateg on (innercateg._lft between root._lft and root._rgt)
    //left join news on (innercateg.id = news.categ_id)
    //where root.parent_id = 3
    //group by innercateg.name_categ, innercateg.slug, innercateg.id, innercateg.parent_id
    //
    //and then need compact for root of innercateg

    public function getCategWithCountComments(int $parent_id)
    {

        $res = [];
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

        $queryAll = DB::table('categs as root')->select(DB::raw('innercateg.name_categ,innercateg.slug, innercateg.id, innercateg.parent_id'))
            ->join('categs as innercateg', function ($join) {
                $join->on('innercateg._lft','>=','root._lft')
                    ->on('innercateg._lft','<=','root._rgt');
            })
            ->leftJoin('news', 'innercateg.id', '=', 'news.categ_id')
            ->where(['root.parent_id'=>$parent_id])
            ->groupBy(['innercateg.name_categ', 'innercateg.slug', 'innercateg.id', 'innercateg.parent_id'])
            ->get();

        foreach ($queryAll as $item){
            $finded = false;
            foreach ($query as $itemquery){
                if ($item->id == $itemquery->id){
                    $finded = true;
                    $newitem = new \stdClass();
                    $newitem->id = $itemquery->id;
                    $newitem->name_categ = $itemquery->name_categ;
                    $newitem->slug = $itemquery->slug;
                    $newitem->parent_id = $itemquery->parent_id;
                    $newitem->countcomments = $itemquery->countcomments;
                    $res[] = $newitem;
                    break;
                }
            }
            if (!$finded) {
                $newitem = new \stdClass();
                $newitem->id = $item->id;
                $newitem->name_categ = $item->name_categ;
                $newitem->slug = $item->slug;
                $newitem->parent_id = $item->parent_id;
                $newitem->countcomments = 0;
                $res[] = $newitem;
            }
        }


        while (true) {
            if ($this->needCompact($res, $parent_id))
                $this->compact($res, $parent_id); else break;
        }

            $res_finally = [];
            foreach ($res as $item){
                if ($item->parent_id == $parent_id){
                $newitem = new \stdClass();
                $newitem->name_categ = $item->name_categ;
                $newitem->slug = $item->slug;
                $newitem->countcomments = $item->countcomments;
                    $res_finally[] = $newitem;
            }
        }

        return $res_finally;

    }


    //select news.id,news.name_news,news.slug, news.body_news, count(comments.id) as countcomments from categs
    //left join news on (categs.id = news.categ_id)
    //left join comments on (news.id = comments.news_id)
    //where categs.id = 221  and comments.published=true
    //group by news.id,news.name_news,news.slug, news.body_news
    //
    // Довыбрать потерянные новости без комментов или без активированных комментов
    //
    //select news.id,news.name_news,news.slug, news.body_news from categs
    //inner join news on (categs.id = news.categ_id)
    //where categs.id = 223
    //group by news.id

    public function getListNewsWithCountComments(int $categ_id)
    {
            $res = [];
            $query = DB::table('categs')->select(DB::raw('news.id,news.name_news,news.slug, news.body_news, count(comments.id) as countcomments'))
            ->leftJoin('news', 'categs.id', '=', 'news.categ_id')
            ->leftJoin('comments', 'news.id', '=', 'comments.news_id')
            ->where(['categs.id'=>$categ_id,'comments.published'=>true])
            ->groupBy(['news.id','news.name_news','news.slug', 'news.body_news'])
            ->get();

            $queryAll = DB::table('categs')->select(DB::raw('news.id,news.name_news,news.slug, news.body_news'))
                ->join('news', 'categs.id', '=', 'news.categ_id')
                ->where(['categs.id'=>$categ_id])
                ->groupBy(['news.id'])
                ->get();


            foreach ($queryAll as $item){
                $finded = false;
                foreach ($query as $itemquery){
                    if ($item->id == $itemquery->id){
                        $finded = true;
                        $newitem = new \stdClass();
                        $newitem->id = $itemquery->id;
                        $newitem->name_news = $itemquery->name_news;
                        $newitem->slug = $itemquery->slug;
                        $newitem->body_news = $itemquery->body_news;
                        $newitem->countcomments = $itemquery->countcomments;
                        $res[] = $newitem;
                        break;
                    }
                }
                if (!$finded) {
                    $newitem = new \stdClass();
                    $newitem->id = $item->id;
                    $newitem->name_news = $item->name_news;
                    $newitem->slug = $item->slug;
                    $newitem->body_news = $item->body_news;
                    $newitem->countcomments = 0;
                    $res[] = $newitem;
                }
            }

            return $res;
    }


    public function getCurrNews($id)
    {
        return News::findOrFail($id)->only('name_news','body_news');
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