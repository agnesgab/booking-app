<?php

namespace App\Services\Comment\Delete;

class CommentDeleteRequest {

    private int $userId;
    private int $commentId;

    public function __construct(int $userId, int $commentId)
    {
        $this->userId = $userId;
        $this->commentId = $commentId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }
}
