<?php

namespace App\Repositories\Rating;

interface RatingRepository {

    public function getApartmentRatings(int $apartmentId);
}