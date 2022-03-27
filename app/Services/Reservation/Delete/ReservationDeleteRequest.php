<?php

namespace App\Services\Reservation\Delete;

class ReservationDeleteRequest {

    private int $userId;
    private int $apartmentId;

    public function __construct(int $userId, int $apartmentId)
    {
        $this->userId = $userId;
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

}