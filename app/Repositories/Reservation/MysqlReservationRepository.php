<?php

namespace App\Repositories\Reservation;

use App\Database;
use App\Models\Reservation;

class MysqlReservationRepository implements ReservationRepository {

    public function getAllReservations(): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function getReservationsIfAvailable(int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function add(Reservation $reservation)
    {
        Database::connection()
            ->insert('reservations', [
                'apartment_id' => $reservation->getApartmentId(),
                'user_id' => $reservation->getUserId(),
                'reservation_date_from' => $reservation->getDateFrom(),
                'reservation_date_to' => $reservation->getDateTo(),
                'total_price' => $reservation->getTotalPrice()
            ]);
    }

    public function delete(int $userId, int $apartmentId)
    {
        $reservationId = Database::connection()
                ->createQueryBuilder()
                ->select('id')
                ->from('reservations')
                ->where('user_id = ?', 'apartment_id = ?')
                ->setParameter(0, $userId)
                ->setParameter(1, $apartmentId)
                ->executeQuery()
                ->fetchOne();

        Database::connection()
            ->delete('reservations',
                ['id' => $reservationId, 'user_id' => $userId, 'apartment_id' => $apartmentId]);
    }

    public function getAllApartmentReservations(int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function getUserReservations(int $userId)
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations', 'r')
            ->innerJoin('r', 'apartments', 'a', 'r.apartment_id = a.id')
            ->where('r.user_id = ?')
            ->setParameter(0, $userId)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}