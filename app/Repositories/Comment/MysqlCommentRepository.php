<?php

namespace App\Repositories\Comment;

use App\Database;
use App\Models\Comment;

class MysqlCommentRepository implements CommentRepository {

    public function showApartmentComments(int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('comments', 'c')
            ->innerJoin('c', 'users', 'u',
                'c.user_id = u.id')
            ->where('apartment_id = ?')
            ->setParameter(0, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function showUsersComments(int $userId, int $apartmentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('rating')
            ->from('comments')
            ->where('user_id = ?', 'apartment_id = ?')
            ->setParameter(0, $userId)
            ->setParameter(1, $apartmentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function add(Comment $comment): void
    {
        Database::connection()
            ->insert('comments', [
                'apartment_id' => $comment->getApartmentId(),
                'user_id' => $comment->getUserId(),
                'comment' => $comment->getComment(),
                'rating' => $comment->getRating(),
            ]);
    }

    public function delete(int $commentId, int $userId)
    {
        Database::connection()
            ->delete('comments', ['user_id' => $userId, 'comment_id' => $commentId]);
    }

    public function edit(int $commentId): array
    {
        return Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('comments', 'c')
            ->innerJoin('c', 'users', 'u', 'c.user_id = u.id')
            ->where('comment_id = ?')
            ->setParameter(0, $commentId)
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function update(Comment $comment)
    {
        Database::connection()->update('comments', [
            'comment' => $comment->getComment(),
            'rating' => $comment->getRating()
        ], ['comment_id' => $comment->getId()]);
    }
}