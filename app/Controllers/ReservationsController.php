<?php

namespace App\Controllers;

use App\Database;
use App\Models\Reservation;
use App\Redirect;
use App\View;

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

        foreach ($myReservationsQuery as $data){
            $reservations[] = new Reservation(
                $data['user_id'],
                $data['apartment_id'],
                $data['name'],
                $data['address'],
                $data['reservation_date_from'],
                $data['reservation_date_to'],
                $data['id']
            );
        }


        return new View('Reservations/index.html', ['reservations' => $reservations]);

    }


    public function show(): View
    {

        return new View('Reservations/show.html');
    }

    public function cancel(array $vars): Redirect {


        Database::connection()
            ->delete('reservations', ['user_id' => $_SESSION['id'],'apartment_id' => (int)$vars['id']]);

        return new Redirect('/reservations');

    }


    //UZTAISĪT EDIT FUNKCIJU

}