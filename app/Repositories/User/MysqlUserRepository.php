<?php

namespace App\Repositories\User;

use App\Database;
use App\Models\User;

class MysqlUserRepository implements UserRepository {

    public function show(int $userId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $userId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function store(User $user)
    {
        Database::connection()
            ->insert('users', [
                'name' => $user->getName(),
                'surname' => $user->getSurname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
    }
}