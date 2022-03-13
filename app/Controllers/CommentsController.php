<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Models\Comment;
use App\Redirect;
use App\View;


class CommentsController
{

    public function comment(array $vars): Redirect
    {

        Database::connection()
            ->insert('comments', [
                'apartment_id' => $vars['id'],
                'user_id' => $_SESSION['id'],
                'comment' => $_POST['comment'],
                'rating' => $_POST['rate'],
            ]);

        return new Redirect('/index/' . $vars['id']);
    }

    public function delete(array $vars): Redirect
    {

        Database::connection()
            ->delete('comments', ['user_id' => $_SESSION['id'], 'comment_id' => (int)$vars['id']]);

        return new Redirect('/index/' . $vars['apartment_id']);
    }

    public function edit(array $vars): View
    {
        $commentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('comments', 'c')
            ->innerJoin('c', 'users', 'u', 'c.user_id = u.id')
            ->where('comment_id = ?')
            ->setParameter(0, $vars['id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $vars['apartment_id'])
            ->executeQuery()
            ->fetchAllAssociative();

        $apartment = [];

        foreach ($apartmentQuery as $data) {
            $apartment = new Apartment(
                $data['id'],
                $data['name'],
                $data['address'],
                $data['description'],
                $data['price']
            );
        }


        $comment = [];

        foreach ($commentQuery as $data) {
            $comment = new Comment(
                $data['name'],
                $data['surname'],
                $data['comment'],
                $data['created_at'],
                (int)$data['rating'],
                $data['user_id'],
                $data['apartment_id'],
                $data['comment_id']

            );
        }


        return new View('Apartments/comment_edit.html', ['comment' => $comment, 'apartment' => $apartment]);
    }

    public function saveChanges(array $vars): Redirect
    {
        Database::connection()->update('comments', [
            'comment' => $_POST['comment'],
            'rating' => $_POST['rate']
        ], ['comment_id' => (int)$vars['id']]);


        return new Redirect('/index/' . $vars['apartment_id']);
    }


}