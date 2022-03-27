<?php

namespace App\Services\Reservation\Add;

class ReservationAddRequest {

    private int $apartmentId;
    private int $userId;
    private string $dateFrom;
    private string $dateTo;
    private int $totalPrice;

    public function __construct(int $apartmentId, int $userId, string $dateFrom, string $dateTo, int $totalPrice)
    {
        $this->apartmentId = $apartmentId;
        $this->userId = $userId;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
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
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

}