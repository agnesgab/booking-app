<?php

namespace App\Services\Reservation\Add;

use App\Database;
use App\Models\Reservation;
use App\Repositories\Reservation\MysqlReservationRepository;
use App\Repositories\Reservation\ReservationRepository;
use App\Services\Price\Calculate\PriceCalculateResponse;

class ReservationAddService {

    private ReservationRepository $reservationRepository;

    public function __construct()
    {
        $this->reservationRepository = new MysqlReservationRepository();
    }

    public function execute(ReservationAddRequest $request){

        $reservation = new Reservation($request->getUserId(), $request->getApartmentId(), '', '',
        $request->getDateFrom(), $request->getDateTo(), $request->getTotalPrice());

        $this->reservationRepository->add($reservation);

    }
}