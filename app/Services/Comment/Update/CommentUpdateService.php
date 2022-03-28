<?php

namespace App\Services\Comment\Update;

use App\Database;
use App\Models\Comment;
use App\Repositories\Comment\MysqlCommentRepository;

class CommentUpdateService {

    private MysqlCommentRepository $commentRepository;

    public function __construct(){

        $this->commentRepository = new MysqlCommentRepository();
    }

    public function execute(CommentUpdateRequest $request){

        $comment = new Comment('','',$request->getCommentText(),
            '', $request->getRating(), null, null, $request->getCommentId());

        $this->commentRepository->update($comment);

    }
}