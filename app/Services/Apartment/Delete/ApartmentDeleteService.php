<?php

namespace App\Services\Apartment\Delete;

use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;

class ApartmentDeleteService {

    private ApartmentRepository $apartmentRepository;

    public function __construct(){

        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(ApartmentDeleteRequest $request){

        $this->apartmentRepository->delete($request->getOwnerId(), $request->getApartmentId());

    }

}
