<?php

namespace App\Controllers;

use App\Database;
use App\Models\Apartment;
use App\Models\Comment;
use App\Redirect;
use App\Services\Comment\Add\CommentAddRequest;
use App\Services\Comment\Add\CommentAddService;
use App\Services\Comment\Delete\CommentDeleteRequest;
use App\Services\Comment\Delete\CommentDeleteService;
use App\Services\Comment\Edit\CommentEditRequest;
use App\Services\Comment\Edit\CommentEditService;
use App\Services\Comment\Update\CommentUpdateRequest;
use App\Services\Comment\Update\CommentUpdateService;
use App\View;
use http\Env\Request;


class CommentsController
{
    public function comment(array $vars): Redirect
    {
        $request = new CommentAddRequest($vars['id'], $_SESSION['id'], $_POST['comment'], $_POST['rate']);
        $service = new CommentAddService();
        $service->execute($request);

        return new Redirect('/index/' . $vars['id']);
    }

    public function delete(array $vars): Redirect
    {
        $request = new CommentDeleteRequest($_SESSION['id'], (int)$vars['id']);
        $service = new CommentDeleteService();
        $service->execute($request);

        return new Redirect('/index/' . $vars['apartment_id']);
    }

    public function edit(array $vars): View
    {
        $commentId = (int)$vars['id'];
        $apartmentId = (int)$vars['apartment_id'];
        $request = new CommentEditRequest($commentId, $apartmentId);
        $service = new CommentEditService();
        $response = $service->execute($request);

        return new View('Apartments/comment_edit.html', ['comment' => $response->getComment(), 'apartment' => $response->getApartment()]);
    }

    public function saveChanges(array $vars): Redirect
    {
        $request = new CommentUpdateRequest((int)$vars['id'], $_POST['comment'], $_POST['rate']);
        $service = new CommentUpdateService();
        $service->execute($request);

        return new Redirect('/index/' . $vars['apartment_id']);
    }

}