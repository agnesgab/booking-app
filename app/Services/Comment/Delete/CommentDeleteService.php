<?php
namespace App\Services\Comment\Delete;

use App\Database;

class CommentDeleteService {

    public function execute(CommentDeleteRequest $request){

        Database::connection()
            ->delete('comments', ['user_id' => $request->getUserId(), 'comment_id' => $request->getCommentId()]);

    }
}