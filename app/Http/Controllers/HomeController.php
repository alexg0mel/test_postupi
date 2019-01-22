<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Slugs\Slug;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function slug(string $slug)
    {
        $slugService = Slug::getInstance();
        $slugService->setSlug($slug);

        if (!$slugService->getFoundPath())
            throw new NotFoundHttpException();

        return view('slug', ['curr_id' => $slugService->getId(), 'slug' => $slug]);
    }
}
