<?php

namespace App\Services\Apartment\Delete;

use App\Database;

class ApartmentDeleteService {

    public function execute(ApartmentDeleteRequest $request){
        Database::connection()
            ->delete('apartments', ['owner_id' => $request->getOwnerId(), 'id' => $request->getApartmentId()]);
    }

}
