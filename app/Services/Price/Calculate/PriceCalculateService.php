<?php

namespace App\Services\Price\Calculate;

use App\Database;

class PriceCalculateService {

    private array $selectedDates;
    private int $totalPrice;

    public function execute(PriceCalculateRequest $request): PriceCalculateResponse {

        foreach ($request->getRange() as $date) {
            $this->selectedDates[] = $date->format('Y-m-d');
        }

        $priceQuery = Database::connection()
            ->createQueryBuilder()
            ->select('price')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchOne();

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
