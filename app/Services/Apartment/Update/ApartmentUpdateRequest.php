<?php

namespace App\Services\Apartment\Update;

class ApartmentUpdateRequest {

    private int $apartmentId;
    private string $name;
    private string $address;
    private string $description;
    private string $availableFrom;
    private string $availableTo;
    private int $price;

    public function __construct(int $apartmentId, string $name, string $address, string $description, string $availableFrom, string $availableTo, int $price)
    {
        $this->apartmentId = $apartmentId;
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->availableFrom = $availableFrom;
        $this->availableTo = $availableTo;
        $this->price = $price;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAvailableTo(): string
    {
        return $this->availableTo;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAvailableFrom(): string
    {
        return $this->availableFrom;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}

