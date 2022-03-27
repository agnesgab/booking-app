<?php

namespace App\Controllers;

use App\Database;
use App\Services\User\Store\UserStoreRequest;
use App\Services\User\Store\UserStoreService;
use App\Validation\LoginValidation;
use App\Validation\SignupValidation;
use App\View;
use App\Redirect;

class UsersController
{
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function signup(): View
    {
        return new View('Users/signup.html');
    }

    public function storeUser(): View
    {
        $validation = new SignupValidation($_POST['email']);

        if ($validation->validateEmail() < 1) {
            $request = new UserStoreRequest($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['password']);
            $service = new UserStoreService();
            $service->execute($request);

            return new View('Users/login.html');
        }

        return new View('Users/signup.html');

    }

    public function login(): View
    {
        return new View('Users/login.html');
    }

    public function startSession(): Redirect
    {
        $validation = new LoginValidation($_POST['email'], $_POST['password']);

        if ($validation->validateLogin()) {
            $_SESSION['id'] = $validation->getSessionId();
            return new Redirect('/select');
        }

        return new Redirect('/login');

    }

    public function select(): View
    {
        return new View('Users/select.html');
    }

    public function logout(): Redirect
    {
        session_destroy();
        return new Redirect('/');
    }

}