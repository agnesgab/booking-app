<?php

namespace App\Services\Reservation\Provide;

use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;
use App\Repositories\Reservation\MysqlReservationRepository;
use App\Repositories\Reservation\ReservationRepository;
use Carbon\CarbonPeriod;

class ReservationProvideService {

    private ReservationRepository $reservationRepository;
    private ApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->reservationRepository = new MysqlReservationRepository();
        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(ReservationProvideRequest $request): ReservationProvideResponse
    {
        $apartmentQuery = $this->apartmentRepository->show($request->getApartmentId());

        $apartment = new Apartment(
            $apartmentQuery[0]['id'],
            $apartmentQuery[0]['name'],
            $apartmentQuery[0]['address'],
            $apartmentQuery[0]['description'],
            $apartmentQuery[0]['price'],
            null,
            $apartmentQuery[0]['available_from'],
            $apartmentQuery[0]['available_to'],

        );

        $reservationsQuery = $this->reservationRepository->getAllApartmentReservations($request->getApartmentId());

        $apartmentReservationRanges = [];
        foreach ($reservationsQuery as $reservation) {
            $apartmentReservationRanges[] = CarbonPeriod::create(
                $reservation['reservation_date_from'], $reservation['reservation_date_to']);

        }

        $unavailableDates = [];
        foreach ($apartmentReservationRanges as $range) {
            foreach ($range as $date) {
                $unavailableDates[] = $date->format('m-d-Y');
            }
        }

        return new ReservationProvideResponse($apartment, $unavailableDates);

    }
}