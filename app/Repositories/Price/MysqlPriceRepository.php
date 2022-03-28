<?php

namespace App\Repositories\Price;

use App\Database;

class MysqlPriceRepository implements PriceRepository {

    public function getPrice(int $apartmentId)
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('price')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchOne();
    }
}