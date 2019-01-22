<?php

namespace App\UseCases\Comments;


use App\Entity\Comment;
use Illuminate\Http\Request;

class CommentService
{
    public function publish($id)
    {
        $comment = Comment::find(['comment_id' => $id])->first();
        $comment->published = true;
        $comment->save();
    }

    public function delete($id)
    {
        $comment = Comment::find(['comment_id' => $id])->first();
        $comment->delete();
    }

    public function newsComments($news_id)
    {
        return Comment::published()->where(['news_id'=>$news_id])->get(['author','body_comment']);
    }

    public function createComment(Request $request, int $news_id)
    {
        $comment = new Comment;
        $comment->news_id= $news_id;
        $comment->author= $request->author;
        $comment->body_comment= $request->body_comment;
        return ($comment->save())? "true":"false";
    }

}