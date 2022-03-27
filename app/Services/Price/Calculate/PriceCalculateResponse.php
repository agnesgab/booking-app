<?php

namespace App\Services\Price\Calculate;

class PriceCalculateResponse {

    private int $totalPrice;

    public function __construct(int $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return array|int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}