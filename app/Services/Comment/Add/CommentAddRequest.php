<?php

namespace App\Services\Comment\Add;

class CommentAddRequest {

    private int $apartmentId;
    private int $userId;
    private string $commentText;
    private ?int $rating;

    public function __construct(int $apartmentId, int $userId, string $commentText, ?int $rating = null)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->commentText = $commentText;
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCommentText(): string
    {
        return $this->commentText;
    }


}