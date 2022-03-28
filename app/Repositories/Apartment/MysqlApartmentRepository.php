<?php

namespace App\Repositories\Apartment;

use App\Database;
use App\Models\Apartment;
use App\Services\Apartment\Edit\ApartmentEditResponse;

class MysqlApartmentRepository implements ApartmentRepository {

    public function save(Apartment $apartment): void
    {
        Database::connection()
            ->insert('apartments', [
                'name' => $apartment->getName(),
                'address' => $apartment->getAddress(),
                'available_from' => $apartment->getAvailableFrom(),
                'available_to' => $apartment->getAvailableTo(),
                'description' => $apartment->getDescription(),
                'price' => $apartment->getPrice(),
                'owner_id' => $apartment->getOwnerId()
            ]);
    }


    public function delete(int $ownerId, int $apartmentId): void
    {
        Database::connection()
            ->delete('apartments', ['owner_id' => $ownerId, 'id' => $apartmentId]);

    }

    public function edit(int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();

    }


    public function update(Apartment $apartment)
    {
        Database::connection()->update('apartments', [
            'name' => $apartment->getName(),
            'address' => $apartment->getAddress(),
            'description' => $apartment->getDescription(),
            'available_from' => $apartment->getAvailableFrom(),
            'available_to' => $apartment->getAvailableTo(),
            'price' => $apartment->getPrice()
        ], ['id' => $apartment->getId()]);
    }

    public function manage(int $ownerId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('owner_id = ?')
            ->setParameter(0, $ownerId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function getAllApartments(): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function show(int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}