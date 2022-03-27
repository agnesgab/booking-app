<?php

namespace App\Services\Apartment\Update;

use App\Database;

class ApartmentUpdateService {

    public function execute(ApartmentUpdateRequest $request){

        Database::connection()->update('apartments', [
            'name' => $request->getName(),
            'address' => $request->getAddress(),
            'description' => $request->getDescription(),
            'available_from' => $request->getAvailableFrom(),
            'available_to' => $request->getAvailableTo()
        ], ['id' => $request->getApartmentId()]);
    }

}