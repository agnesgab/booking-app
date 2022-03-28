<?php

namespace App\Repositories\Reservation;

use App\Models\Reservation;

interface ReservationRepository {

    public function getAllReservations();
    public function getReservationsIfAvailable(int $apartmentId);
    public function add(Reservation $reservation);
    public function delete(int $userId, int $apartmentId);
    public function getAllApartmentReservations(int $apartmentId);
    public function getUserReservations(int $userId);
}