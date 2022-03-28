<?php

namespace App\Services\Apartment\Edit;

use App\Database;
use App\Models\Apartment;
use App\Repositories\Apartment\MysqlApartmentRepository;

class ApartmentEditService {

    private MysqlApartmentRepository $apartmentRepository;

    public function __construct(){

        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(ApartmentEditRequest $request): ApartmentEditResponse
    {
        $apartmentInfo = $this->apartmentRepository->edit($request->getApartmentId());

        $apartment = [];
        foreach ($apartmentInfo as $data) {
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