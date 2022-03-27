<?php

namespace App\Services\Apartment\Edit;

use App\Database;
use App\Models\Apartment;

class ApartmentEditService {


    public function execute(ApartmentEditRequest $request): ApartmentEditResponse
    {
        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $request->getApartmentId())
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

        return new ApartmentEditResponse($apartment);
    }
}