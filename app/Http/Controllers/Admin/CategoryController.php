<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Categ;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categ::defaultOrder()->withDepth()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Categ::defaultOrder()->withDepth()->get();

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name_categ' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255',
            'descr' => 'nullable|string|max:255',
            'parent' => 'nullable|integer|exists:categs,id',
        ]);

        $category = Categ::create([
            'name_categ' => $request['name_categ'],
            'slug' => $request['slug'],
            'descr' => $request['desrc'],
            'parent_id' => $request['parent'],
        ]);

        return redirect()->route('admin.categories.show', $category);
    }

    public function show(Categ $category)
    {

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Categ $category)
    {
        $parents = Categ::defaultOrder()->withDepth()->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Categ $category)
    {
        $this->validate($request, [
            'name_categ' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|max:255',
            'descr' => 'nullable|string|max:255',
            'parent' => 'nullable|integer|exists:categs,id',
        ]);

        $category->update([
            'name_categ' => $request['name_categ'],
            'slug' => $request['slug'],
            'descr' => $request['descr'],
            'parent_id' => $request['parent'],
        ]);

        return redirect()->route('admin.categories.show', $category);
    }


    public function destroy(Categ $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }

    public function first(Categ $category)
    {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }

        return redirect()->route('admin.categories.index');
    }

    public function up(Categ $category)
    {
        $category->up();

        return redirect()->route('admin.categories.index');
    }

    public function down(Categ $category)
    {
        $category->down();

        return redirect()->route('admin.categories.index');
    }

    public function last(Categ $category)
    {
        if ($last = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($last);
        }

        return redirect()->route('admin.categories.index');
    }

}
