<?php

namespace App\Controllers;

use App\Database;
use App\Redirect;


class CommentsController
{

    public function comment(array $vars)
    {

        Database::connection()
            ->insert('comments', [
                'apartment_id' => $vars['id'],
                'user_id' => $_SESSION['id'],
                'comment' => $_POST['comment']
            ]);

        return new Redirect('/index/' . $vars['id']);
    }
}