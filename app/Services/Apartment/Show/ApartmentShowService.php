<?php

namespace App\Services\Apartment\Show;

use App\Models\Apartment;
use App\Models\Comment;
use App\Repositories\Apartment\ApartmentRepository;
use App\Repositories\Apartment\MysqlApartmentRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\MysqlCommentRepository;
use App\Repositories\Rating\MysqlRatingRepository;
use App\Repositories\Rating\RatingRepository;
use App\Repositories\User\MysqlUserRepository;
use App\Repositories\User\UserRepository;

class ApartmentShowService {

    private ApartmentRepository $apartmentRepository;
    private UserRepository $userRepository;
    private CommentRepository $commentRepository;
    private RatingRepository $ratingRepository;

    public function __construct(){

        $this->apartmentRepository = new MysqlApartmentRepository();
        $this->userRepository = new MysqlUserRepository();
        $this->commentRepository = new MysqlCommentRepository();
        $this->ratingRepository = new MysqlRatingRepository();
    }

    public function execute(ApartmentShowRequest $request): ApartmentShowResponse {

        $apartmentQuery = $this->apartmentRepository->show($request->getApartmentId());

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

        $userNameSurnameQuery = $this->userRepository->show($request->getSessionId());

        $name = '';
        $surname = '';
        foreach ($userNameSurnameQuery as $data) {
            $name = $data['name'];
            $surname = $data['surname'];
        }

        $commentsQuery = $this->commentRepository->showApartmentComments($request->getApartmentId());

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

        $ratingsQuery = $this->ratingRepository->getApartmentRatings($request->getApartmentId());

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

        $userRatingAndCommentsQuery = $this->commentRepository->showUsersComments($request->getSessionId(), $request->getApartmentId());

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