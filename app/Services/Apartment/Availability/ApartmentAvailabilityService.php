<?php

namespace App\Services\Apartment\Availability;

use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;
use App\Repositories\Reservation\MysqlReservationRepository;
use App\Repositories\Reservation\ReservationRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ApartmentAvailabilityService {

    private ApartmentRepository $apartmentRepository;
    private ReservationRepository $reservationRepository;

    public function __construct(){

        $this->apartmentRepository = new MysqlApartmentRepository();
        $this->reservationRepository = new MysqlReservationRepository();
    }


    public function execute(ApartmentAvailabilityRequest $request): ApartmentAvailabilityResponse
    {
        $selectedFrom = Carbon::createFromFormat('Y-m-d', $request->getDateFrom())->toDateString();
        $selectedTo = Carbon::createFromFormat('Y-m-d', $request->getDateTo())->toDateString();
        $selectedDatesRange = CarbonPeriod::create($selectedFrom, $selectedTo);

        $allApartments = $this->apartmentRepository->getAllApartments();
        $allReservations = $this->reservationRepository->getAllReservations();

        $availableId = [];

        foreach ($allApartments as $apartment) {
            $range = CarbonPeriod::create(
                $apartment['available_from'], $apartment['available_to']);

            if ($range->overlaps($selectedDatesRange)) {
                $availableId[] = (int)$apartment['id'];
            }
        }

        foreach ($allReservations as $reservation) {
            $range = CarbonPeriod::create(
                $reservation['reservation_date_from'], $reservation['reservation_date_to']);

            if (!$range->overlaps($selectedDatesRange) && in_array($reservation['apartment_id'], $availableId)) {
                $availableId[] = (int)$reservation['apartment_id'];
            }
        }

        $availableId = array_unique($availableId);
        $availableApartments = [];

        foreach ($availableId as $id) {
            $availableApartmentsQuery = $this->reservationRepository->getReservationsIfAvailable($id);

            foreach ($availableApartmentsQuery as $data) {
                $availableApartments[] = new Apartment(
                    $data['id'],
                    $data['name'],
                    $data['address'],
                    $data['description'],
                    $data['price'],
                    $data['owner_id'],
                    $data['available_from'],
                    $data['available_to']
                );
            }
        }

        return new ApartmentAvailabilityResponse($availableApartments, $selectedFrom, $selectedTo);

    }
}