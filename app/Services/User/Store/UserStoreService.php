<?php

namespace App\Services\User\Store;

use App\Database;

class UserStoreService {

    public function execute(UserStoreRequest $request){

        Database::connection()
            ->insert('users', [
                'name' => $request->getName(),
                'surname' => $request->getSurname(),
                'email' => $request->getEmail(),
                'password' => $request->getPassword()
            ]);
    }

}