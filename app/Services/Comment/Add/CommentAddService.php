<?php

namespace App\Services\Comment\Add;

use App\Database;
use App\Models\Comment;
use App\Repositories\Apartment\MysqlApartmentRepository;
use App\Repositories\Comment\MysqlCommentRepository;

class CommentAddService {

    private MysqlCommentRepository $commentRepository;

    public function __construct(){

        $this->commentRepository = new MysqlCommentRepository();
    }

    public function execute(CommentAddRequest $request){

        $comment = new Comment('','', $request->getCommentText(), '',
            $request->getRating(), $request->getUserId(), $request->getApartmentId());

        $this->commentRepository->add($comment);

    }

}