<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Models\Reservation;
use App\Redirect;
use App\View;
use Carbon\CarbonPeriod;

class ReservationsController
{


    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function index(): View
    {

        $myReservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations', 'r')
            ->innerJoin('r', 'apartments', 'a', 'r.apartment_id = a.id')
            ->where('r.user_id = ?')
            ->setParameter(0, (int)$_SESSION['id'])
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


        return new View('Reservations/index.html', ['reservations' => $reservations]);

    }


    public function show(): View
    {

        return new View('Reservations/show.html');
    }

    public function cancel(array $vars): Redirect
    {
        $id = Database::connection()
            ->createQueryBuilder()
            ->select('id')
            ->from('reservations')
            ->where('user_id = ?', 'apartment_id = ?')
            ->setParameter(0, $_SESSION['id'])
            ->setParameter(1, (int)$vars['id'])
            ->executeQuery()
            ->fetchOne();

        Database::connection()
            ->delete('reservations', ['id' => (int)$id, 'user_id' => $_SESSION['id'], 'apartment_id' => (int)$vars['id']]);

        return new Redirect('/reservations');

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function doReservation(array $vars): View
    {

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, (int)$vars['id'])
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
            ->setParameter(0, (int)$vars['id'])
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


        return new View('Apartments/reservation.html', ['apartment' => $apartment, 'dates' => $unavailableDates]);

    }

    public function validateReservation(array $vars): Redirect
    {

        $inputFrom = date("Y-m-d", strtotime($_POST['selected_from']));
        $inputTo = date("Y-m-d", strtotime($_POST['selected_to']));

        $selectedFrom = \Carbon\Carbon::createFromFormat('Y-m-d', $inputFrom);
        $selectedTo = \Carbon\Carbon::createFromFormat('Y-m-d', $inputTo);
        $selectedDatesRange = CarbonPeriod::create($selectedFrom, $selectedTo);

        $selectedDates = [];

        foreach ($selectedDatesRange as $date) {
            $selectedDates[] = $date->format('Y-m-d');
        }

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, (int)$vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();


        foreach ($apartmentQuery as $data) {
            $availableDatesRange = CarbonPeriod::create($data['available_from'], $data['available_to']);
        }


        $reservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, (int)$vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $apartmentReservationRanges = [];

        foreach ($reservationsQuery as $reservation) {
            $apartmentReservationRanges[] = CarbonPeriod::create(
                $reservation['reservation_date_from'], $reservation['reservation_date_to']);

        }

        $count = 0;

        foreach ($apartmentReservationRanges as $range) {

            if (!$selectedDatesRange->overlaps($availableDatesRange) || $selectedDatesRange->overlaps($range)) {
                $count += 1;
            }
        }


        if ($count < 1) {

            $priceQuery = Database::connection()
                ->createQueryBuilder()
                ->select('price')
                ->from('apartments')
                ->where('id = ?')
                ->setParameter(0, (int)$vars['id'])
                ->executeQuery()
                ->fetchOne();


            $days = count($selectedDates);
            $totalPrice = (int)$priceQuery * $days;

            Database::connection()
                ->insert('reservations', [
                    'apartment_id' => (int)$vars['id'],
                    'user_id' => $_SESSION['id'],
                    'reservation_date_from' => $inputFrom,
                    'reservation_date_to' => $inputTo,
                    'total_price' => $totalPrice
                ]);

        }


        return new Redirect('/reservations');

    }


}