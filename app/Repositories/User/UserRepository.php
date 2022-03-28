<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepository {

    public function show(int $userId);
    public function store(User $user);

}