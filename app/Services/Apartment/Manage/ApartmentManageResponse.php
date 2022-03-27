<?php

namespace App\Services\Apartment\Manage;

class ApartmentManageResponse {
    private array $apartments;

    public function __construct(array $apartments)
    {
        $this->apartments = $apartments;
    }

    /**
     * @return array
     */
    public function getApartments(): array
    {
        return $this->apartments;
    }
}