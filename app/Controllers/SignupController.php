<?php

namespace App\Controllers;

use App\View;


class SignupController
{

    public function start(): View
    {

        if ($_SESSION) {
            session_destroy();
        }

        return new View('Users/start.html');
    }
}