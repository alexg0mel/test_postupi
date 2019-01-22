<?php

namespace App\UseCases\Slugs;

use App\Entity\Categ;
use App\DTO\SlugPath;

class Slug
{
    private  $slug;
    private  $slugPaths;
    private  $foundPath;
    private  $id;

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
        $this->id = 0;
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

    public function isNews(): string
    {
        return $this->slugPaths[count($this->slugPaths)-1]->isNews ? "true":"false";
    }

    public function getId(): int
    {
        return $this->id;
    }


    private function parseSlug()
    {
        $paths = explode('/', $this->slug);
        $depth = 0;
        $isnews = false;
        $slugfound = false;
        $categ = Categ::whereRoot()->where(['slug' => $paths[0]])->first();
        if (!is_null($categ)) {
            $slugfound = true;
            $this->id = $categ->id;
        }
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
                            $this->id = $child->id;
                            break;
                        }
                     }
                    if (!$slugfound) {
                        if ($islast) {
                            foreach ($parentCateg->news as $news) {
                                if ($news->slug == $path) {
                                    $isnews = true;
                                    $slugfound = true;
                                    $this->id = $news->id;
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
                                $this->id = $news->id;
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