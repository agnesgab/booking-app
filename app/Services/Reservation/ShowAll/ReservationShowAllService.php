<?php

namespace App\Services\Reservation\ShowAll;

use App\Database;
use App\Models\Reservation;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;
use App\Repositories\Reservation\MysqlReservationRepository;
use App\Repositories\Reservation\ReservationRepository;

class ReservationShowAllService {

    private ReservationRepository $reservationRepository;
    private ApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->reservationRepository = new MysqlReservationRepository();
        $this->apartmentRepository = new MysqlApartmentRepository();
    }


    public function execute(ReservationShowAllRequest $request): ReservationShowAllResponse
    {
        $myReservationsQuery = $this->reservationRepository->getUserReservations($request->getUserId());

        $reservations = [];
        foreach ($myReservationsQuery as $data) {
            $reservations[] = new Reservation(
                $data['user_id'],
                $data['apartment_id'],
                $data['name'],
                $data['address'],
                $data['reservation_date_from'],
                $data['reservation_date_to'],
                $data['total_price'],
                $data['id']
            );
        }

        return new ReservationShowAllResponse($reservations);

    }
}