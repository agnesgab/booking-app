<?php

namespace App\Models;

class Apartment {

    private ?int $id;
    private string $name;
    private string $address;
    private ?string $availableFrom;
    private ?string $availableTo;
    private string $description;

    /**
     * @param string $name
     * @param string $address
     * @param string|null $availableFrom
     * @param string|null $availableTo
     * @param string $description
     */
    public function __construct(?int $id, string $name, string $address, ?string $availableFrom, ?string $availableTo, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->availableFrom = $availableFrom;
        $this->availableTo = $availableTo;
        $this->description = $description;
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
     * @return string|null
     */
    public function getAvailableFrom(): ?string
    {
        return $this->availableFrom;
    }

    /**
     * @return string|null
     */
    public function getAvailableTo(): ?string
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


}