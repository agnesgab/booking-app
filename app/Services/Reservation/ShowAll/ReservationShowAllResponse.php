<?php

namespace App\Services\Reservation\ShowAll;

class ReservationShowAllResponse
{
    private array $reservations;

    public function __construct(array $reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     * @return array
     */
    public function getReservations(): array
    {
        return $this->reservations;
    }
}