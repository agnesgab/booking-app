<?php

namespace App\Services\User\Store;

use App\Database;
use App\Models\User;
use App\Repositories\User\MysqlUserRepository;
use App\Repositories\User\UserRepository;

class UserStoreService {

    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new MysqlUserRepository();
    }

    public function execute(UserStoreRequest $request){

        $user = new User($request->getName(), $request->getSurname(), $request->getPassword(), $request->getEmail());
        $this->userRepository->store($user);

    }

}