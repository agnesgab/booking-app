<?php

namespace App\Models;

class Comment
{
    private ?int $id;
    private string $userName;
    private string $userSurname;
    private string $comment;
    private string $createdAt;
    private ?string $rating;
    private ?int $userId;
    private ?int $apartmentId;
    private string $stars;

    /**
     * @param string $userName
     * @param string $userSurname
     * @param string $comment
     * @param string|null $createdAt
     */
    public function __construct(string $userName, string $userSurname, string $comment, string $createdAt, ?string $rating = null, ?int $userId = null, ?int $apartmentId = null, ?int $id = null)
    {
        $this->comment = $comment;
        $this->createdAt = $createdAt;
        $this->userName = $userName;
        $this->userSurname = $userSurname;
        $this->apartmentId = $apartmentId;
        $this->rating = $rating;
        $this->userId = $userId;
        $this->id = $id;
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
    public function getId(): ?int
    {
        return $this->id;
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
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getUserSurname(): string
    {
        return $this->userSurname;
    }

    /**
     * @return string|null
     */
    public function getRating(): ?string
    {
        return $this->rating;
    }

    /**
     * @return string
     */
    public function getStars(): string
    {
        $this->stars = str_repeat('★', $this->getRating());
        return $this->stars;
    }

}