<?php

namespace App\Repositories\Price;

interface PriceRepository {

    public function getPrice(int $apartmentId);
}