<?php

namespace Tests;

use App\Models\Apartment;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{

    public function testGetName()
    {

        $apartment = new Apartment(1, 'Hello', 'Hello sreet', 'blablabla', 300);
        $this->assertEquals('Hello', $apartment->getName());
    }

    public function testGetId()
    {

        $apartment = new Apartment(1, 'Hello', 'Hello sreet', 'blablabla', 300);
        $this->assertEquals(1, $apartment->getId());
    }

    public function testGetAddress()
    {

        $apartment = new Apartment(1, 'Hello', 'Hello sreet', 'blablabla', 300);
        $this->assertEquals('Hello sreet', $apartment->getAddress());
    }

    public function testGetDescription()
    {
        $apartment = new Apartment(1, 'Hello', 'Hello sreet', 'blablabla', 300);
        $this->assertEquals('blablabla', $apartment->getDescription());
    }

    public function testGetPrice()
    {
        $apartment = new Apartment(1, 'Hello', 'Hello sreet', 'blablabla', 300);
        $this->assertEquals(300, $apartment->getPrice());
    }
}
