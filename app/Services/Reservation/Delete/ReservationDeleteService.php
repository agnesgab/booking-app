<?php

namespace App\Services\Reservation\Delete;

use App\Database;
use App\Repositories\Reservation\MysqlReservationRepository;
use App\Repositories\Reservation\ReservationRepository;

class ReservationDeleteService
{
    private ReservationRepository $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new MysqlReservationRepository();
    }

    public function execute(ReservationDeleteRequest $request)
    {
        $this->reservationRepository->delete($request->getUserId(), $request->getApartmentId());

    }

}