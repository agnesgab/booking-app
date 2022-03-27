<?php

namespace App\Services\Reservation\Provide;

class ReservationProvideRequest {

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