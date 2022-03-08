<?php

namespace App\Models;

class Comment
{

    private string $userName;
    private string $userSurname;
    private string $comment;
    private string $createdAt;
    private ?int $apartmentId;


    /**
     * @param string $userName
     * @param string $userSurname
     * @param string $comment
     * @param string|null $createdAt
     */
    public function __construct(string $userName, string $userSurname, string $comment, string $createdAt, ?int $apartmentId = null)
    {

        $this->comment = $comment;
        $this->createdAt = $createdAt;


        $this->userName = $userName;
        $this->userSurname = $userSurname;
        $this->apartmentId = $apartmentId;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
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


}