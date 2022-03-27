<?php

namespace App\Services\Reservation\Provide;

use App\Models\Apartment;

class ReservationProvideResponse
{
    private Apartment $apartment;
    private array $unavailableDates;

    public function __construct(Apartment $apartment, array $unavailableDates)
    {
        $this->apartment = $apartment;
        $this->unavailableDates = $unavailableDates;
    }

    /**
     * @return Apartment
     */
    public function getApartment(): Apartment
    {
        return $this->apartment;
    }

    /**
     * @return array
     */
    public function getUnavailableDates(): array
    {
        return $this->unavailableDates;
    }
}