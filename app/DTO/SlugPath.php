<?php

namespace App\DTO;


class SlugPath
{
    public $path;
    public $slug;
    public $isNews;

    public function __construct($path, $slug, $isNews)
    {
        $this->path = $path;
        $this->slug = $slug;
        $this->isNews = $isNews;
    }
}