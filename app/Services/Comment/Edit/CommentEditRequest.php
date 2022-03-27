<?php

namespace App\Services\Comment\Edit;

class CommentEditRequest {

    private int $commentId;
    private int $apartmentId;

    public function __construct(int $commentId, int $apartmentId)
    {
        $this->commentId = $commentId;
        $this->apartmentId = $apartmentId;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }
}