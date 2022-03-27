<?php

namespace App\Services\Reservation\Add;

use App\Database;
use App\Services\Price\Calculate\PriceCalculateResponse;

class ReservationAddService {

    public function execute(ReservationAddRequest $request){

        Database::connection()
            ->insert('reservations', [
                'apartment_id' => $request->getApartmentId(),
                'user_id' => $request->getUserId(),
                'reservation_date_from' => $request->getDateFrom(),
                'reservation_date_to' => $request->getDateTo(),
                'total_price' => $request->getTotalPrice()
            ]);
    }
}