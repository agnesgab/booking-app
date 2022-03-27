<?php


declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{

    public function testExample(): void
    {
        $stack = [];

        $this->assertCount(0, $stack);
    }

    public function testAbc(){
        $this->assertEquals(true, true);
    }

}


