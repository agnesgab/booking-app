<?php

namespace App\Services\Apartment\Manage;

use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;

class ApartmentManageService {

    private ApartmentRepository $apartmentRepository;

    public function __construct(){

        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(ApartmentManageRequest $request){

        $apartmentsInfo = $this->apartmentRepository->manage($request->getUserId());

        $apartments = [];

        foreach ($apartmentsInfo as $data) {
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