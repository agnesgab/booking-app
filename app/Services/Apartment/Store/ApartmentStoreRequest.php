<?php

namespace App\Services\Apartment\Store;

class ApartmentStoreRequest {

    private int $ownerId;
    private string $name;
    private string $address;
    private string $availableFrom;
    private string $availableTo;
    private string $description;
    private int $price;

    public function __construct(
        int    $ownerId,
        string $name,
        string $address,
        string $availableFrom,
        string $availableTo,
        string $description,
        int    $price
    )
    {
        $this->ownerId = $ownerId;
        $this->name = $name;
        $this->address = $address;
        $this->availableFrom = $availableFrom;
        $this->availableTo = $availableTo;
        $this->description = $description;
        $this->price = $price;

    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
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
    public function getAvailableTo(): string
    {
        return $this->availableTo;
    }

    /**
     * @return string
     */
    public function getAvailableFrom(): string
    {
        return $this->availableFrom;
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
    public function getName(): string
    {
        return $this->name;
    }

}