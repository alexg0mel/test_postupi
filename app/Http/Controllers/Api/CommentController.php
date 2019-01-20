<?php

namespace App\Http\Controllers\Api;

use App\Entity\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function publish(Request $request, int $comment_id)
    {
        //всю эту логику стоило вынести в отдельный сервис, но не в этот раз....
        $comment = Comment::find(['comment_id' => $comment_id])->first();
        $comment->published = true;
        $comment->save();
        return [
            'name' => 'publish',
        ];
    }

    public function delete(Request $request, int $comment_id)
    {
        $comment = Comment::find(['comment_id' => $comment_id])->first();
        $comment->delete();
        return [
            'name' => 'delete',
        ];
    }

}
