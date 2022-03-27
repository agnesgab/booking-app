<?php

namespace Tests;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetName(){

        $user = new User('Agnese', 'Gabrisa', '111', 'a@g.com');
        $this->assertEquals('Agnese', $user->getName());
    }

    public function testGetSurname(){

        $user = new User('Agnese', 'Gabrisa', '111', 'a@g.com');
        $this->assertEquals('Gabrisa', $user->getSurname());
    }

    public function testGetPassword(){

        $user = new User('Agnese', 'Gabrisa', '111', 'a@g.com');
        $this->assertEquals('111', $user->getPassword());
    }

    public function testGetEmail(){

        $user = new User('Agnese', 'Gabrisa', '111', 'a@g.com');
        $this->assertEquals('a@g.com', $user->getEmail());
    }
}
