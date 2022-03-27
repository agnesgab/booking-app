<?php

namespace App\Services\Comment\Edit;

use App\Models\Apartment;
use App\Models\Comment;

class CommentEditResponse {

    private Comment $comment;
    private Apartment $apartment;

    public function __construct(Comment $comment, Apartment $apartment)
    {
        $this->comment = $comment;
        $this->apartment = $apartment;
    }

    /**
     * @return Apartment
     */
    public function getApartment(): Apartment
    {
        return $this->apartment;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }
}