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

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

}
