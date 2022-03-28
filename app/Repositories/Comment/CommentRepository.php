<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

interface CommentRepository {

    public function add(Comment $comment);
    public function delete(int $commentId, int $userId);
    public function edit(int $commentId);
    public function update(Comment $comment);
    public function showApartmentComments(int $apartmentId);
    public function showUsersComments(int $userId, int $apartmentId);
}
