<?php

namespace App\UseCases\Slugs;

use App\Entity\Categ;
use App\DTO\SlugPath;

class Slug
{
    private $slug;
    private  $slugPaths;
    private  $foundPath;

    /**
     * @var Slug $self
     */
    private static $self;

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance(): Slug
    {
        if (self::$self === null) {
            self::$self = new self;
        }

        return self::$self;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        $this->slugPaths = [];
        $this->foundPath = true;
        $this->parseSlug();
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getFoundPath(): bool
    {
        return $this->foundPath;
    }

    public function getSlugPaths(): array
    {
        return $this->slugPaths;
    }


    private function parseSlug()
    {
        $paths = explode('/', $this->slug);
        $depth = 0;
        $isnews = false;
        $slugfound = false;
        $categ = Categ::whereRoot()->where(['slug' => $paths[0]])->first();
        if (!is_null($categ)) $slugfound = true;
        $parentCateg = null;
        $lastPath = '';
        foreach ($paths as $path){
            $depth ++;
            $islast = (count($paths) == $depth);
            if ($lastPath != '') {
                $slugfound = false;
                $lastPath .='/';
                if (!is_null($categ)) {
                    $parentCateg =  $categ;
                    foreach ($categ->children as $child){
                        if ($child->slug == $path) {
                            $categ = $child;
                            $slugfound = true;
                            break;
                        }
                     }
                    if (!$slugfound) {
                        if ($islast) {
                            foreach ($parentCateg->news as $news) {
                                if ($news->slug == $path) {
                                    $isnews = true;
                                    $slugfound = true;
                                    break;
                                }}
                        }
                    }
                } else {
                    if ($islast) {
                        foreach ($parentCateg->news as $news) {
                            if ($news->slug == $path) {
                                $isnews = true;
                                $slugfound = true;
                                break;
                            }}
                        }
                    }
                }
            $this->foundPath = ($this->foundPath && $slugfound);
            $lastPath .=$path;
            $this->slugPaths[] = new SlugPath($lastPath,$path,$isnews);
        }
    }


}