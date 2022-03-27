<?php

namespace App\Services\Apartment\Availability;

class ApartmentAvailabilityResponse {


    private array $availableApartments;
    private string $dateFrom;
    private string $dateTo;

    public function __construct(array $availableApartments, string $dateFrom, string $dateTo)
    {
        $this->availableApartments = $availableApartments;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo;
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return array
     */
    public function getAvailableApartments(): array
    {
        return $this->availableApartments;
    }
}