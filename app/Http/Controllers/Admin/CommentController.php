<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Comment;
use App\UseCases\Users\ApiTokenServices;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::unpublished()->orderBy('news_id')->with('news')->get();
        $token = (new ApiTokenServices(\Auth::user()))->getToken();

        return view('admin.comments.index', compact('comments', 'token'));
    }

}
