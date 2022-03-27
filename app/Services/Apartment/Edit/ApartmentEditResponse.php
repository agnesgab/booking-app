<?php

namespace App\Services\Apartment\Edit;

use App\Models\Apartment;

class ApartmentEditResponse {

    private Apartment $apartment;

    public function __construct(Apartment $apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * @return Apartment
     */
    public function getApartment(): Apartment
    {
        return $this->apartment;
    }
}