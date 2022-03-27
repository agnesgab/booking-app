<?php

namespace App\Services\Comment\Update;

use App\Database;

class CommentUpdateService {

    public function execute(CommentUpdateRequest $request){
        Database::connection()->update('comments', [
            'comment' => $request->getCommentText(),
            'rating' => $request->getRating()
        ], ['comment_id' => $request->getCommentId()]);
    }
}