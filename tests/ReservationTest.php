<?php

namespace Tests;

use App\Models\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testGetUserId()
    {
        $reservation = new Reservation(1, 3, 'Sunnyside', 'Hello street', '11-01-2022', '20-01-2022', 1000);
        $this->assertEquals(1, $reservation->getUserId());
    }

    public function testGetApartmentId()
    {
        $reservation = new Reservation(1, 3, 'Sunnyside', 'Hello street', '11-01-2022', '20-01-2022', 1000);
        $this->assertEquals(3, $reservation->getApartmentId());
    }

    public function testGetDateFrom()
    {
        $reservation = new Reservation(1, 3, 'Sunnyside', 'Hello street', '11-01-2022', '20-01-2022', 1000);
        $this->assertEquals('11-01-2022', $reservation->getDateFrom());
    }

    public function testGetDateTo()
    {
        $reservation = new Reservation(1, 3, 'Sunnyside', 'Hello street', '11-01-2022', '20-01-2022', 1000);
        $this->assertEquals('20-01-2022', $reservation->getDateTo());
    }

    public function testGetTotalPrice()
    {
        $reservation = new Reservation(1, 3, 'Sunnyside', 'Hello street', '11-01-2022', '20-01-2022', 1000);
        $this->assertEquals(1000, $reservation->getTotalPrice());
    }

}
