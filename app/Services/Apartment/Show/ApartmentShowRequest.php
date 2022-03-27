<?php

namespace App\Services\Apartment\Show;

class ApartmentShowRequest {

    private int $apartmentId;
    private int $sessionId;

    public function __construct(int $apartmentId, int $sessionId)
    {
        $this->apartmentId = $apartmentId;
        $this->sessionId = $sessionId;
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
    public function getSessionId(): int
    {
        return $this->sessionId;
    }
}