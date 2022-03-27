<?php

namespace App\Controllers;

use App\Redirect;
use App\Services\Price\Calculate\PriceCalculateRequest;
use App\Services\Price\Calculate\PriceCalculateService;
use App\Services\Reservation\Provide\ReservationProvideRequest;
use App\Services\Reservation\Provide\ReservationProvideService;
use App\Services\Reservation\ShowAll\ReservationShowAllRequest;
use App\Services\Reservation\ShowAll\ReservationShowAllService;
use App\Services\Reservation\Add\ReservationAddRequest;
use App\Services\Reservation\Add\ReservationAddService;
use App\Services\Reservation\Delete\ReservationDeleteRequest;
use App\Services\Reservation\Delete\ReservationDeleteService;
use App\Validation\ReservationValidation;
use App\View;

class ReservationsController
{

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function index(): View
    {
        $userId = (int)$_SESSION['id'];
        $request = new ReservationShowAllRequest($userId);
        $service = new ReservationShowAllService();
        $response = $service->execute($request);

        return new View('Reservations/index.html', ['reservations' => $response->getReservations()]);
    }

    public function show(): View
    {
        return new View('Reservations/show.html');
    }

    public function cancel(array $vars): Redirect
    {
        $userId = (int)$_SESSION['id'];
        $apartmentId = (int)$vars['id'];

        $request = new ReservationDeleteRequest($userId, $apartmentId);
        $service = new ReservationDeleteService();
        $service->execute($request);

        return new Redirect('/reservations');

    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function doReservation(array $vars): View
    {
        $apartmentId = (int)$vars['id'];
        $request = new ReservationProvideRequest($apartmentId);
        $service = new ReservationProvideService();
        $response = $service->execute($request);

        return new View('Apartments/reservation.html', ['apartment' => $response->getApartment(), 'dates' => $response->getUnavailableDates()]);

    }

    public function validateReservation(array $vars): Redirect
    {
        $inputDateFrom = date("Y-m-d", strtotime($_POST['selected_from']));
        $inputDateTo = date("Y-m-d", strtotime($_POST['selected_to']));
        $apartmentId = (int)$vars['id'];
        $userId = $_SESSION['id'];
        $validation = new ReservationValidation($apartmentId, $inputDateFrom, $inputDateTo);
        $validation->validateDates();

        if ($validation->getOverlaps() < 1) {

            $priceRequest = new PriceCalculateRequest($apartmentId, $validation->getSelectedDatesRange());
            $priceService = new PriceCalculateService();
            $priceResponse = $priceService->execute($priceRequest);

            $request = new ReservationAddRequest((int)$vars['id'], $userId,
                $inputDateFrom, $inputDateTo, $priceResponse->getTotalPrice());
            $service = new ReservationAddService();
            $service->execute($request);

        }
        return new Redirect('/reservations');
    }

}