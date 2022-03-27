<?php

namespace App\Services\Apartment\Show;

use App\Database;
use App\Models\Apartment;
use App\Models\Comment;

class ApartmentShowService {

    public function execute(ApartmentShowRequest $request): ApartmentShowResponse {

        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

        $apartment = new Apartment(
            $apartmentQuery[0]['id'],
            $apartmentQuery[0]['name'],
            $apartmentQuery[0]['address'],
            $apartmentQuery[0]['description'],
            $apartmentQuery[0]['price'],
            $apartmentQuery[0]['owner_id'],
            $apartmentQuery[0]['available_from'],
            $apartmentQuery[0]['available_to']
        );

        $userNameSurnameQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $request->getSessionId())
            ->executeQuery()
            ->fetchAllAssociative();

        $name = '';
        $surname = '';

        foreach ($userNameSurnameQuery as $data) {
            $name = $data['name'];
            $surname = $data['surname'];
        }

        $commentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('comments', 'c')
            ->innerJoin('c', 'users', 'u',
                'c.user_id = u.id')
            ->where('apartment_id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

        $comments = [];

        foreach ($commentsQuery as $data) {
            $comments[] = new Comment(
                $data['name'],
                $data['surname'],
                $data['comment'],
                $data['created_at'],
                $data['rating'],
                $data['user_id'],
                $data['apartment_id'],
                $data['comment_id']
            );
        }

        $ratingsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('rating')
            ->from('comments')
            ->where('apartment_id = ?')
            ->setParameter(0, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

        $allRatings = [];

        foreach ($ratingsQuery as $data) {

            if ($data['rating'] !== null) {
                $allRatings[] = (int)$data['rating'];
            }
        }

        if(count($allRatings) > 0){
            $averageRating = array_sum($allRatings) / count($allRatings);
            $averageRating = number_format($averageRating, 1);
        } else {
            $averageRating = 0;
        }

        $userRatingAndCommentsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('rating')
            ->from('comments')
            ->where('user_id = ?', 'apartment_id = ?')
            ->setParameter(0, $request->getSessionId())
            ->setParameter(1, $request->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();


        $count = 0;
        $currentRating = null;
        foreach ($userRatingAndCommentsQuery as $data) {
            if ($data['rating'] !== null) {
                $count++;
                $currentRating = $data['rating'];
            } else {
                $currentRating = 0;
            }
        }

        $ratingNotExist = $count === 0;

        return new ApartmentShowResponse($apartment, $comments, $averageRating, $currentRating, $ratingNotExist, $request->getSessionId(), $name, $surname);
    }

}