<?php

namespace App\Services\Reservation\Provide;

use App\Database;
use App\Models\Apartment;
use Carbon\CarbonPeriod;

class ReservationProvideService {

    public function execute(ReservationProvideRequest $request): ReservationProvideResponse
    {
        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

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

        $reservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

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