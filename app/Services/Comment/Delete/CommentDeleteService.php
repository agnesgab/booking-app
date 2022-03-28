<?php
namespace App\Services\Comment\Delete;

use App\Database;
use App\Repositories\Comment\MysqlCommentRepository;

class CommentDeleteService {

    private MysqlCommentRepository $commentRepository;

    public function __construct(){
        $this->commentRepository = new MysqlCommentRepository();
    }

    public function execute(CommentDeleteRequest $request){

        $this->commentRepository->delete($request->getCommentId(), $request->getUserId());


    }
}