<?php

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Crumbs;
use App\Entity\Categ;
use App\Entity\News;


Breadcrumbs::register('home', function (Crumbs $crumbs) {
    $crumbs->push('Home', route('home'));
});

Breadcrumbs::register('admin.home', function (Crumbs $crumbs) {
    $crumbs->push('Admin', route('admin.home'));
});


Breadcrumbs::register('login', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Login', route('login'));
});

Breadcrumbs::register('register', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Login', route('register'));
});

Breadcrumbs::register('password.request', function (Crumbs $crumbs) {
    $crumbs->parent('login');
    $crumbs->push('Reset Password', route('password.request'));
});

Breadcrumbs::register('password.reset', function (Crumbs $crumbs) {
    $crumbs->parent('password.request');
    $crumbs->push('Change', route('password.reset'));
});


// Categories

Breadcrumbs::register('admin.categories.index', function (Crumbs $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Categories', route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.create', function (Crumbs $crumbs) {
    $crumbs->parent('admin.categories.index');
    $crumbs->push('Create', route('admin.categories.create'));
});

Breadcrumbs::register('admin.categories.show', function (Crumbs $crumbs, Categ $category) {
    if ($parent = $category->parent) {
        $crumbs->parent('admin.categories.show', $parent);
    } else {
        $crumbs->parent('admin.categories.index');
    }
    $crumbs->push($category->name_categ, route('admin.categories.show', $category));
});

Breadcrumbs::register('admin.categories.edit', function (Crumbs $crumbs, Categ $category) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push('Edit', route('admin.categories.edit', $category));
});

//News

Breadcrumbs::register('admin.categories.news.show', function (Crumbs $crumbs, Categ $category, News $news) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push($news->name_news, route('admin.categories.news.show', [$category, $news]));
});

Breadcrumbs::register('admin.categories.news.edit', function (Crumbs $crumbs, Categ $category, News $news) {
    $crumbs->parent('admin.categories.show', $category, $news);
    $crumbs->push('Edit', route('admin.categories.news.edit', [$category, $news]));
});

Breadcrumbs::register('admin.categories.news.create', function (Crumbs $crumbs, Categ $category) {
    $crumbs->parent('admin.categories.show', $category);
    $crumbs->push('Create', route('admin.categories.news.create', $category));
});