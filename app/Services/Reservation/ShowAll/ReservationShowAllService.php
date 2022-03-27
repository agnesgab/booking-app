<?php

namespace App\Services\Reservation\ShowAll;

use App\Database;
use App\Models\Reservation;

class ReservationShowAllService {

    public function execute(ReservationShowAllRequest $request): ReservationShowAllResponse
    {
        $myReservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations', 'r')
            ->innerJoin('r', 'apartments', 'a', 'r.apartment_id = a.id')
            ->where('r.user_id = ?')
            ->setParameter(0, $request->getUserId())
            ->executeQuery()
            ->fetchAllAssociative();

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