<?php

namespace Tests;

use App\Models\Apartment;
use App\Models\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testGetName()
    {
        $comment = new Comment('Agnese', 'G', 'Hello world', '22-02-2022 12:00', 4);
        $this->assertEquals('Agnese', $comment->getUserName());
    }

    public function testGetSurname()
    {
        $comment = new Comment('Agnese', 'G', 'Hello world', '22-02-2022 12:00', 4);
        $this->assertEquals('G', $comment->getUserSurname());
    }

    public function testGetCommentText()
    {
        $comment = new Comment('Agnese', 'G', 'Hello world', '22-02-2022 12:00', 4);
        $this->assertEquals('Hello world', $comment->getComment());
    }

    public function testGetCeratedAt()
    {
        $comment = new Comment('Agnese', 'G', 'Hello world', '22-02-2022 12:00', 4);
        $this->assertEquals('22-02-2022 12:00', $comment->getCreatedAt());
    }

    public function testGetRating()
    {
        $comment = new Comment('Agnese', 'G', 'Hello world', '22-02-2022 12:00', 4);
        $this->assertEquals(4, $comment->getRating());
    }

}
