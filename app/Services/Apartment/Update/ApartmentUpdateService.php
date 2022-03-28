<?php

namespace App\Services\Apartment\Update;

use App\Models\Apartment;
use App\Repositories\Apartment\MysqlApartmentRepository;

class ApartmentUpdateService
{
    private MysqlApartmentRepository $apartmentRepository;

    public function __construct()
    {
        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(ApartmentUpdateRequest $request)
    {
        $apartment = new Apartment($request->getApartmentId(), $request->getName(), $request->getAddress(),
            $request->getDescription(), $request->getPrice(), null, $request->getAvailableFrom(), $request->getAvailableTo());

        $this->apartmentRepository->update($apartment);
    }

}