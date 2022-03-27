<?php

namespace App\Services\Comment\Add;

use App\Database;

class CommentAddService {

    public function execute(CommentAddRequest $request){

        Database::connection()
            ->insert('comments', [
                'apartment_id' => $request->getApartmentId(),
                'user_id' => $request->getUserId(),
                'comment' => $request->getCommentText(),
                'rating' => $request->getRating(),
            ]);

    }

}