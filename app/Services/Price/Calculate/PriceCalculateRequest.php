<?php

namespace App\Services\Price\Calculate;

use Carbon\CarbonPeriod;

class PriceCalculateRequest {

    private int $apartmentId;
    private CarbonPeriod $range;

    public function __construct(int $apartmentId, CarbonPeriod $range)
    {
        $this->apartmentId = $apartmentId;
        $this->range = $range;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }

    /**
     * @return CarbonPeriod
     */
    public function getRange(): CarbonPeriod
    {
        return $this->range;
    }
}