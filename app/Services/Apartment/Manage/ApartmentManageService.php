<?php

namespace App\Services\Apartment\Manage;

use App\Database;
use App\Models\Apartment;

class ApartmentManageService {

    public function execute(ApartmentManageRequest $request){

        $myApartmentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('owner_id = ?')
            ->setParameter(0, $request->getUserId())
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

        return new ApartmentManageResponse($apartments);
    }
}