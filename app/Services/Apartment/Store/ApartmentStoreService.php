<?php

namespace App\Services\Apartment\Store;

use App\Database;

class ApartmentStoreService {

    public function execute(ApartmentStoreRequest $request){

        Database::connection()
            ->insert('apartments', [
                'name' => $request->getName(),
                'address' => $request->getAddress(),
                'available_from' => $request->getAvailableFrom(),
                'available_to' => $request->getAvailableTo(),
                'description' => $request->getDescription(),
                'price' => $request->getPrice(),
                'owner_id' => $request->getOwnerId()
            ]);
    }

}