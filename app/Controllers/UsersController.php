<?php

namespace App\Controllers;

use App\Database;
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

        $userEmail = $_POST['email'];
        $emailQuery = Database::connection()
            ->createQueryBuilder()
            ->select('email')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $userEmail)
            ->executeQuery()
            ->fetchAllAssociative();


        if (empty($emailQuery)) {
            Database::connection()
                ->insert('users', [
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'email' => $_POST['email'],
                    'password' => $_POST['email']
                ]);
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

        $userEmail = $_POST['email'];
        $userQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('email = ?')
            ->setParameter(0, $userEmail)
            ->executeQuery()
            ->fetchAllAssociative();

        if (!empty($userQuery)) {
            $_SESSION['id'] = (int)$userQuery[0]['id'];
            return new Redirect('/index');
        }

        return new Redirect('/login');

    }

    public function select(): View{

        return new View('Users/select.html');
    }

}