<?php

namespace App\Services\Comment\Edit;

use App\Models\Apartment;
use App\Models\Comment;
use App\Repositories\Apartment\MysqlApartmentRepository;
use App\Repositories\Comment\MysqlCommentRepository;

class CommentEditService {

    private MysqlCommentRepository $commentRepository;
    private MysqlApartmentRepository $apartmentRepository;

    public function __construct(){

        $this->commentRepository = new MysqlCommentRepository();
        $this->apartmentRepository = new MysqlApartmentRepository();
    }

    public function execute(CommentEditRequest $request){

        $commentQuery = $this->commentRepository->edit($request->getCommentId());
        $apartmentQuery = $this->apartmentRepository->show($request->getApartmentId());

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