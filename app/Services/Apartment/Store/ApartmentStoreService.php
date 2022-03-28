<?php

namespace App\Services\Apartment\Store;

use App\Models\Apartment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;

class ApartmentStoreService {

    private ApartmentRepository $apartmentRepository;

    public function __construct(){

        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(ApartmentStoreRequest $request): Apartment
    {
        $apartment = new Apartment(null, $request->getName(), $request->getAddress(), $request->getDescription(),
            $request->getPrice(), $request->getOwnerId(), $request->getAvailableFrom(), $request->getAvailableTo());

        $this->apartmentRepository->save($apartment);

        return $apartment;
    }

}