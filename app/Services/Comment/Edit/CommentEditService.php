<?php

namespace App\Services\Comment\Edit;

use App\Database;
use App\Models\Apartment;
use App\Models\Comment;

class CommentEditService {

    public function execute(CommentEditRequest $request){

        $commentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('comments', 'c')
            ->innerJoin('c', 'users', 'u', 'c.user_id = u.id')
            ->where('comment_id = ?')
            ->setParameter(0, $request->getCommentId())
            ->executeQuery()
            ->fetchAllAssociative();

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

        $apartment = null;

        foreach ($apartmentQuery as $data) {
            $apartment = new Apartment(
                $data['id'],
                $data['name'],
                $data['address'],
                $data['description'],
                $data['price']
            );
        }

        $comment = null;

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
        return new CommentEditResponse($comment, $apartment);
    }
}