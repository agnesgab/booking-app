<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Models\Comment;
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
                $apartmentData['description'],
                $apartmentData['price'],
                $apartmentData['owner_id'],
                $apartmentData['available_from'],
                $apartmentData['available_to']
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
                'price' => $_POST['price'],
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
            $apartmentQuery[0]['price'],
            null,
            $apartmentQuery[0]['available_from'],
            $apartmentQuery[0]['available_to']

        );

        $userNameSurnameQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $_SESSION['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $name = '';
        $surname = '';

        foreach ($userNameSurnameQuery as $data) {
            $name = $data['name'];
            $surname = $data['surname'];
        }

        $commentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('comments', 'c')
            ->innerJoin('c', 'users', 'u',
                'c.user_id = u.id')
            ->where('apartment_id = ?')
            ->setParameter(0, $vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();


        $comments = [];

        foreach ($commentsQuery as $data) {
            $comments[] = new Comment(
                $data['name'],
                $data['surname'],
                $data['comment'],
                $data['created_at']
            );
        }

        return new View('Apartments/show.html', [
            'apartment' => $apartment,
            'name' => $name,
            'surname' => $surname,
            'comments' => $comments]);
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

        foreach ($apartmentsQuery as $apartment){

            $range = CarbonPeriod::create(
                $apartment['available_from'], $apartment['available_to']);

            if($range->overlaps($selectedDatesRange)){
                $availableId[] = (int)$apartment['id'];
            }
        }

        foreach ($reservationsQuery as $reservation){

            $range = CarbonPeriod::create(
                $reservation['reservation_date_from'], $reservation['reservation_date_to']);

            if(!$range->overlaps($selectedDatesRange) && in_array($reservation['apartment_id'], $availableId)){

                $availableId[] = (int)$reservation['apartment_id'];
            }
        }


        $availableId = array_unique($availableId);
        $availableApartments = [];

        foreach ($availableId as $id){

            $availableApartmentsQuery = Database::connection()
                ->createQueryBuilder()
                ->select('*')
                ->from('apartments')
                ->where('id = ?')
                ->setParameter(0, $id)
                ->executeQuery()
                ->fetchAllAssociative();

            foreach ($availableApartmentsQuery as $data){

                $availableApartments[] = new Apartment(
                    $data['id'],
                    $data['name'],
                    $data['address'],
                    $data['description'],
                    $data['price'],
                    $data['owner_id'],
                    $data['reservation_date_from'],
                    $data['reservation_date_to']
                );
            }

        }


        return new View('Apartments/available.html', [
            'available_apartments' => $availableApartments,
            'from' => $_POST['selected_from'],
            'to' => $_POST['selected_to']]);

    }

    public function manage(): View
    {
        $myApartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments', 'r')
            ->where('owner_id = ?')
            ->setParameter(0, (int)$_SESSION['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $apartments = [];

        foreach ($myApartmentsQuery as $data) {
            $apartments[] = new Apartment(
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

        return new View('Apartments/owned.html', ['apartments' => $apartments]);
    }

    public function delete(array $vars): Redirect
    {

        Database::connection()
            ->delete('apartments', ['owner_id' => $_SESSION['id'], 'id' => (int)$vars['id']]);

        return new Redirect('/manage');
    }

    public function edit(array $vars)
    {

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $apartment = [];

        foreach ($apartmentQuery as $data) {
            $apartment = new Apartment(
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

        return new View('Apartments/edit.html', ['apartment' => $apartment]);
    }

    public function saveChanges(array $vars)
    {

        Database::connection()->update('apartments', [
            'name' => $_POST['name'],
            'address' => $_POST['address'],
            'description' => $_POST['description'],
            'available_from' => $_POST['available_from'],
            'available_to' => $_POST['available_to']
        ], ['id' => (int)$vars['id']]);

        return new Redirect('/manage');
    }


}


