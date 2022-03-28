<?php

namespace App\Services\Price\Calculate;

use App\Database;
use App\Repositories\Price\MysqlPriceRepository;
use App\Repositories\Price\PriceRepository;

class PriceCalculateService {

    private array $selectedDates;
    private int $totalPrice;
    private PriceRepository $priceRepository;

    public function __construct()
    {
        $this->priceRepository = new MysqlPriceRepository();
    }

    public function execute(PriceCalculateRequest $request): PriceCalculateResponse {

        foreach ($request->getRange() as $date) {
            $this->selectedDates[] = $date->format('Y-m-d');
        }

        $priceQuery = $this->priceRepository->getPrice($request->getApartmentId());

        $days = count($this->getSelectedDates())-1;
        $this->totalPrice = (int)$priceQuery * $days;

        return new PriceCalculateResponse($this->getTotalPrice());
    }

    /**
     * @return array
     */
    public function getSelectedDates(): array
    {
        return $this->selectedDates;
    }

    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }
}
