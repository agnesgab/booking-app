<?php

namespace App\Repositories\Apartment;

use App\Models\Apartment;

interface ApartmentRepository {

    public function save(Apartment $apartment);
    public function delete(int $ownerId, int $apartmentId);
    public function edit(int $apartmentId);
    public function update(Apartment $apartment);
    public function manage(int $ownerId);
    public function getAllApartments();
    public function show(int $apartmentId);

}