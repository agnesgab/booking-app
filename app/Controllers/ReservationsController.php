<?php

namespace App\Controllers;

use App\Database;
use App\Models\Reservation;
use App\View;

class ReservationsController
{


    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function index(array $vars): View
    {

        $reservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('reservations')
            ->where('user_id = ?')
            ->setParameter(0, $_SESSION['id'])
            ->executeQuery()
            ->fetchAllAssociative();



        //šeit vajadzētu taisīt join, bet nu pagaidām tā


        $myReservations = [];

        foreach ($reservationsQuery as $data) {

            $apartmentQuery = Database::connection()
                ->createQueryBuilder()
                ->select('*')
                ->from('apartments')
                ->where('id = ?')
                ->setParameter(0, $data['apartment_id'])
                ->executeQuery()
                ->fetchAllAssociative();

            $myReservations[] = new Reservation(
                $data['user_id'],
                $data['apartment_id'],
                $apartmentQuery[0]['name'],
                $apartmentQuery[0]['address'],
                $data['reservation_date_from'],
                $data['reservation_date_to']
            );

        }

        return new View('Reservations/index.html', ['reservations' => $myReservations]);

    }


    public function show(): View
    {

        return new View('Reservations/show.html');
    }

    public function delete(){
        var_dump('remove this');
    }


    //delete
    //edit

}