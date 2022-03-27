<?php

namespace App\Services\Apartment\Show;

use App\Models\Apartment;

class ApartmentShowResponse {

    private Apartment $apartment;
    private array $comments;
    private float $averageRating;
    private ?int $currentRating;
    private bool $ratingNotExist;
    private int $sessionId;
    private string $name;
    private string $surname;

    public function __construct(Apartment $apartment, array $comments, float $averageRating, ?int $currentRating, bool $ratingNotExist, int $sessionId, string $name, string $surname)
    {

        $this->apartment = $apartment;
        $this->comments = $comments;
        $this->averageRating = $averageRating;
        $this->currentRating = $currentRating;
        $this->ratingNotExist = $ratingNotExist;
        $this->sessionId = $sessionId;
        $this->name = $name;
        $this->surname = $surname;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @return float
     */
    public function getAverageRating(): float
    {
        return $this->averageRating;
    }

    /**
     * @return Apartment
     */
    public function getApartment(): Apartment
    {
        return $this->apartment;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return int
     */
    public function getSessionId(): int
    {
        return $this->sessionId;
    }

    /**
     * @return int
     */
    public function getCurrentRating(): ?int
    {
        return $this->currentRating;
    }

    /**
     * @return bool
     */
    public function isRatingNotExist(): bool
    {
        return $this->ratingNotExist;
    }


}