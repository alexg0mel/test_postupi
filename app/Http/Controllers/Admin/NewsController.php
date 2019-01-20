<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\News;
use App\Entity\Categ;

class NewsController extends Controller
{
    public function create(Categ $category)
    {

        return view('admin.categories.news.create', compact('category'));
    }

    public function store(Request $request, Categ $category)
    {
        $this->validate($request, [
            'name_news' => 'required|string|max:255|unique:news,name_news,,id,categ_id,'.$category->id,
            'slug' => 'required|string|max:255|unique:news,slug,,id,categ_id,'.$category->id,
            'body_news' => 'required|string',
        ]);

        $news = News::create([
            'name_news' => $request['name_news'],
            'slug' => $request['slug'],
            'body_news' => $request['body_news'],
            'categ_id' => $category->id,

        ]);

        return redirect()->route('admin.categories.news.show', compact('category', 'news'));
    }

    public function show(Categ $category, News $news)
    {

        return view('admin.categories.news.show', compact('category', 'news'));
    }

    public function edit(Categ $category, News $news)
    {
        return view('admin.categories.news.edit', compact('category', 'news'));
    }

    public function update(Request $request, Categ $category, News $news)
    {

        $this->validate($request, [
            'name_news' => 'required|string|max:255|unique:news,name_news,'.$news->id.',id,categ_id,'.$category->id,
            'slug' => 'required|string|max:255|unique:news,slug,'.$news->id.',id,categ_id,'.$category->id,
            'body_news' => 'required|string',
        ]);

        $news->update([
            'name_news' => $request['name_news'],
            'slug' => $request['slug'],
            'body_news' => $request['body_news'],

        ]);

        return redirect()->route('admin.categories.news.show', compact('category', 'news'));
    }

    public function destroy(Categ $category, News $news)
    {
        $news->delete();

        return redirect()->route('admin.categories.show', $category->id);
    }

}
