<?php

namespace App\Models;

class Apartment
{
    private string $name;
    private string $address;
    private string $description;
    private int $ownerId;
    private ?int $id;
    private ?string $availableFrom;
    private ?string $availableTo;

    /**
     * @param string $name
     * @param string $address
     * @param string $description
     * @param int|null $id
     * @param string|null $availableFrom
     * @param string|null $availableTo
     */
    public function __construct(?int $id, string $name, string $address, string $description, int $ownerId = null, ?string $availableFrom = null, ?string $availableTo = null)
    {

        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->ownerId = $ownerId;
        $this->availableFrom = $availableFrom;
        $this->id = $id;
        $this->availableTo = $availableTo;


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

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }


}