<?php

namespace App\Repositories\Rating;

use App\Database;

class MysqlRatingRepository implements RatingRepository {

    public function getApartmentRatings(int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('rating')
            ->from('comments')
            ->where('apartment_id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}