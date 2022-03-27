<?php

namespace App\Services\Apartment\Availability;

use App\Database;
use App\Models\Apartment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ApartmentAvailabilityService {


    public function execute(ApartmentAvailabilityRequest $request): ApartmentAvailabilityResponse
    {
        $selectedFrom = Carbon::createFromFormat('Y-m-d', $request->getDateFrom())->toDateString();
        $selectedTo = Carbon::createFromFormat('Y-m-d', $request->getDateTo())->toDateString();
        $selectedDatesRange = CarbonPeriod::create($selectedFrom, $selectedTo);

        $apartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->executeQuery()
            ->fetchAllAssociative();

        $reservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->executeQuery()
            ->fetchAllAssociative();

        $availableId = [];

        foreach ($apartmentsQuery as $apartment) {

            $range = CarbonPeriod::create(
                $apartment['available_from'], $apartment['available_to']);

            if ($range->overlaps($selectedDatesRange)) {
                $availableId[] = (int)$apartment['id'];
            }
        }

        foreach ($reservationsQuery as $reservation) {
            $range = CarbonPeriod::create(
                $reservation['reservation_date_from'], $reservation['reservation_date_to']);

            if (!$range->overlaps($selectedDatesRange) && in_array($reservation['apartment_id'], $availableId)) {
                $availableId[] = (int)$reservation['apartment_id'];
            }
        }

        $availableId = array_unique($availableId);
        $availableApartments = [];

        foreach ($availableId as $id) {
            $availableApartmentsQuery = Database::connection()
                ->createQueryBuilder()
                ->select('*')
                ->from('apartments')
                ->where('id = ?')
                ->setParameter(0, $id)
                ->executeQuery()
                ->fetchAllAssociative();

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