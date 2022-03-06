<?php

namespace App\Models;

class Reservation {

    private int $userId;
    private int $apartmentId;
    private string $apartmentName;
    private string $apartmentAddress;
    private string $dateFrom;
    private string $dateTo;
    private ?int $id;

    /**
     * @param int $userId
     * @param int $apartmentId
     * @param string $apartmentName
     * @param string $apartmentAddress
     * @param string $dateFrom
     * @param string $dateTo
     * @param ?int $id
     */
    public function __construct(
        int $userId,
        int $apartmentId,
        string $apartmentName,
        string $apartmentAddress,
        string $dateFrom,
        string $dateTo,
        ?int $id = null)
    {

        $this->userId = $userId;
        $this->apartmentId = $apartmentId;
        $this->apartmentName = $apartmentName;
        $this->apartmentAddress = $apartmentAddress;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->id = $id;


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
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getApartmentAddress(): string
    {
        return $this->apartmentAddress;
    }

    /**
     * @return string
     */
    public function getApartmentName(): string
    {
        return $this->apartmentName;
    }


}