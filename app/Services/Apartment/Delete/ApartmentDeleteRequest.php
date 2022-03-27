<?php

namespace App\Services\Apartment\Delete;

class ApartmentDeleteRequest {

    private int $apartmentId;
    private int $ownerId;

    public function __construct(int $apartmentId, int $ownerId){
        $this->apartmentId = $apartmentId;
        $this->ownerId = $ownerId;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }
}