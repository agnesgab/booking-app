<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Services\Apartment\Availability\ApartmentAvailabilityRequest;
use App\Services\Apartment\Availability\ApartmentAvailabilityService;
use App\Services\Apartment\Delete\ApartmentDeleteRequest;
use App\Services\Apartment\Delete\ApartmentDeleteService;
use App\Services\Apartment\Edit\ApartmentEditRequest;
use App\Services\Apartment\Edit\ApartmentEditService;
use App\Services\Apartment\Manage\ApartmentManageRequest;
use App\Services\Apartment\Manage\ApartmentManageService;
use App\Services\Apartment\Show\ApartmentShowRequest;
use App\Services\Apartment\Show\ApartmentShowService;
use App\Services\Apartment\Store\ApartmentStoreRequest;
use App\Services\Apartment\Store\ApartmentStoreService;
use App\Services\Apartment\Update\ApartmentUpdateRequest;
use App\Services\Apartment\Update\ApartmentUpdateService;
use App\View;
use App\Redirect;

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
        $request = new ApartmentStoreRequest($_SESSION['id'], $_POST['name'], $_POST['address'], $_POST['available_from'],
            $_POST['available_to'], $_POST['description'], $_POST['price']
        );

        $service = new ApartmentStoreService();
        $service->execute($request);

        return new Redirect('/manage');
    }

    public function show(array $vars): View
    {
        $apartmentId = (int)$vars['id'];
        $sessionId = (int)$_SESSION['id'];
        $request = new ApartmentShowRequest($apartmentId, $sessionId);

        $service = new ApartmentShowService();
        $response = $service->execute($request);

        return new View('Apartments/show.html', [
            'apartment' => $response->getApartment(),
            'user_id' => $response->getSessionId(),
            'name' => $response->getName(),
            'surname' => $response->getSurname(),
            'comments' => $response->getComments(),
            'average_rating' => $response->getAverageRating(),
            'rating_not_exist' => $response->isRatingNotExist(),
            'current_rating' => $response->getCurrentRating()
        ]);
    }


    public function dates(): View
    {
        return new View('Users/dates.html');
    }

    public function showAvailable(): View
    {
        $request = new ApartmentAvailabilityRequest($_POST['selected_from'], $_POST['selected_to']);
        $service = new ApartmentAvailabilityService();
        $response = $service->execute($request);

        return new View('Apartments/available.html', [
            'available_apartments' => $response->getAvailableApartments(),
            'from' => $response->getDateFrom(),
            'to' => $response->getDateTo()]);
    }

    public function manage(): View
    {
        $userId = (int)$_SESSION['id'];
        $request = new ApartmentManageRequest($userId);
        $service = new ApartmentManageService();
        $response = $service->execute($request);

        return new View('Apartments/owned.html', ['apartments' => $response->getApartments()]);
    }

    public function delete(array $vars): Redirect
    {
        $request = new ApartmentDeleteRequest((int)$vars['id'], $_SESSION['id']);
        $service = new ApartmentDeleteService();
        $service->execute($request);

        return new Redirect('/manage');
    }

    public function edit(array $vars)
    {
        $request = new ApartmentEditRequest((int)$vars['id']);
        $service = new ApartmentEditService();
        $response = $service->execute($request);

        return new View('Apartments/edit.html', ['apartment' => $response->getApartment()]);
    }

    public function saveChanges(array $vars): Redirect
    {
        $request = new ApartmentUpdateRequest((int)$vars['id'], $_POST['name'], $_POST['address'], $_POST['description'],
            $_POST['available_from'], $_POST['available_to']);
        $service = new ApartmentUpdateService();
        $service->execute($request);

        return new Redirect('/manage');
    }

}


