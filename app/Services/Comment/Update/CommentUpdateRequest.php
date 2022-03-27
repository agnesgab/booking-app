<?php

namespace App\Services\Comment\Update;

class CommentUpdateRequest {

    private int $commentId;
    private string $commentText;
    private ?int $rating;

    public function __construct(int $commentId, string $commentText, ?int $rating)
    {
        $this->commentId = $commentId;
        $this->commentText = $commentText;
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getCommentId(): int
    {
        return $this->commentId;
    }

    /**
     * @return string
     */
    public function getCommentText(): string
    {
        return $this->commentText;
    }

    /**
     * @return int
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }
}