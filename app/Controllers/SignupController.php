<?php

namespace App\Controllers;

use App\View;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SignupController
{

    public function start(): View
    {
        $r = [
            ['15-03-2022', '20-03-2022'],
            ['22-03-2022', '24-03-2022'],
            ['26-03-2022', '30-03-2022']

        ];

        $dates = [];

        foreach ($r as $d) {
            [$startDate, $endDate] = $d;
            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $date) {
                $dates[] = $date->format('m-d-Y');
            }
        }
        if ($_SESSION) {
            session_destroy();
        }

        return new View('Users/start.html', ['reservations' => $dates]);
    }
}