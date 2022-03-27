<?php

namespace App\Services\Apartment\Edit;

class ApartmentEditRequest {

    private int $apartmentId;

    public function __construct(int $apartmentId)
    {
        $this->apartmentId = $apartmentId;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }
}