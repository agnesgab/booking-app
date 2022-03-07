<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\View;
use App\Redirect;
use Carbon\CarbonPeriod;


class ApartmentsController
{

    public function index(): View
    {

        $apartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->executeQuery()
            ->fetchAllAssociative();

        $apartments = [];

        foreach ($apartmentsQuery as $apartmentData) {

            $apartments[] = new Apartment(
                $apartmentData['id'],
                $apartmentData['name'],
                $apartmentData['address'],
                $apartmentData['available_from'],
                $apartmentData['available_to'],
                $apartmentData['description']
            );

        }

        return new View('Apartments/index.html', ['apartments' => $apartments]);

    }


    public function create(): View
    {
        return new View('Apartments/create.html');

    }

    public function store(): Redirect
    {

        Database::connection()
            ->insert('apartments', [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'available_from' => $_POST['available_from'],
                'available_to' => $_POST['available_to'],
                'description' => $_POST['description'],
                'owner_id' => $_SESSION['id']
            ]);

        return new Redirect('/manage');

    }

    public function show(array $vars)
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
            $apartmentQuery[0]['available_from'],
            $apartmentQuery[0]['available_to']

        );


        return new View('Apartments/show.html', ['apartment' => $apartment]);
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
            $apartmentQuery[0]['available_from'],
            $apartmentQuery[0]['available_to'],
            $apartmentQuery[0]['description']
        );

        return new View('Apartments/reservation.html', ['apartment' => $apartment]);

    }

    public function validateReservation(array $vars)
    {

        $selectedFrom = \Carbon\Carbon::createFromFormat('Y-m-d', $_POST['selected_from']);
        $selectedTo = \Carbon\Carbon::createFromFormat('Y-m-d', $_POST['selected_to']);
        $selectedDatesRange = CarbonPeriod::create($selectedFrom, $selectedTo);

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, (int)$vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();


        foreach ($apartmentQuery as $data) {
            $availableFrom = $data['available_from'];
            $availableTo = $data['available_to'];
        }

        //KOPĒJAIS APARTMENTA AVAILABLE RANGE
        $availableDatesRange = CarbonPeriod::create($availableFrom, $availableTo);

        //
        $reservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, (int)$vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        //visi iegūtie rezervāciju periodi
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

            Database::connection()
                ->insert('reservations', [
                    'apartment_id' => (int)$vars['id'],
                    'user_id' => $_SESSION['id'],
                    'reservation_date_from' => $_POST['selected_from'],
                    'reservation_date_to' => $_POST['selected_to']
                ]);

        }

        return new Redirect('/reservations');

    }

    public function dates()
    {

        return new View('Users/dates.html');
    }

    public function showAvailable()
    {


        $selectedFrom = \Carbon\Carbon::createFromFormat('Y-m-d', $_POST['selected_from']);
        $selectedTo = \Carbon\Carbon::createFromFormat('Y-m-d', $_POST['selected_to']);
        $selectedDatesRange = CarbonPeriod::create($selectedFrom, $selectedTo);

        $apartmentsAndReservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations', 'r')
            ->innerJoin('r', 'apartments',
                'a', 'r.apartment_id = a.id')
            ->executeQuery()
            ->fetchAllAssociative();

        $availableApartments = [];

        foreach ($apartmentsAndReservationsQuery as $data) {

            $seasonAvailableRange = CarbonPeriod::create(
                $data['available_from'], $data['available_to']
            );
            $notAvailableRanges = CarbonPeriod::create(
                $data['reservation_date_from'], $data['reservation_date_to']
            );

            if ($seasonAvailableRange->overlaps($selectedDatesRange) &&
                !$notAvailableRanges->overlaps($selectedDatesRange)) {
                $availableApartments[] = new Apartment(
                    $data['apartment_id'],
                    $data['name'],
                    $data['address'],
                    $data['description'],
                );
            }


        }

        return new View('Apartments/available.html', [
            'available_apartments' => $availableApartments,
            'from' => $_POST['selected_from'],
            'to' => $_POST['selected_to']]);

    }

    public function manage(): View{
        $myApartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments', 'r')
            ->where('owner_id = ?')
            ->setParameter(0, (int)$_SESSION['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $apartments = [];

        foreach ($myApartmentsQuery as $data){
            $apartments[] = new Apartment(
                $data['id'],
                $data['name'],
                $data['address'],
                $data['description'],
                $data['owner_id'],
                $data['available_from'],
                $data['available_to']

            );
        }

        return new View('Apartments/owned.html', ['apartments' => $apartments]);
    }

    public function delete(array $vars): Redirect{

        Database::connection()
            ->delete('apartments', ['owner_id' => $_SESSION['id'],'id' => (int)$vars['id']]);

        return new Redirect('/manage');
    }


}


