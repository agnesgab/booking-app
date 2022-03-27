<?php

namespace App\Services\Reservation\Delete;

use App\Database;

class ReservationDeleteService
{
    public function execute(ReservationDeleteRequest $request)
    {
        $reservationId = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('reservations')
            ->where('user_id = ?', 'apartment_id = ?')
            ->setParameter(0, $request->getUserId())
            ->setParameter(1, $request->getApartmentId())
            ->executeQuery()
            ->fetchOne();

        Database::connection()
            ->delete('reservations',
                ['id' => $reservationId, 'user_id' => $request->getUserId(), 'apartment_id' => $request->getApartmentId()]);
    }

}