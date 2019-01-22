<?php

namespace App\Http\Controllers\Api;

use App\UseCases\Categories\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function rootCateg()
    {
        return $this->categoryService->getRootCategWithCountNews();
    }

    public function categs($currid)
    {
        return $this->categoryService->getCategWithCountComments($currid);
    }

    public function news($currid)
    {
        return $this->categoryService->getListNewsWithCountComments($currid);
    }

    public function currNews($currid)
    {
        return $this->categoryService->getCurrNews($currid);
    }

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

}
