<?php

namespace App\Http\Controllers\Api;

use App\Entity\Comment;
use App\UseCases\Comments\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    private $commentService;

    public function publish(Request $request, int $comment_id)
    {
        $this->commentService->publish($comment_id);
        return [
            'name' => 'publish',
        ];
    }

    public function delete(Request $request, int $comment_id)
    {
        $this->commentService->delete($comment_id);
        return [
            'name' => 'delete',
        ];
    }

    public function comments($parent_id)
    {
        return $this->commentService->newsComments($parent_id);
    }

    public function newComment(Request $request, $news_id)
    {
        return $this->commentService->createComment($request, $news_id);
    }

    public function __construct(CommentService $commentService)
    {

        $this->commentService = $commentService;
    }

}
