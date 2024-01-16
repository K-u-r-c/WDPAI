<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/PostReply.php';

class PostReplyRepository extends Repository {
    public function getAllRepliesForPost($post_id) : array {
        $query = "SELECT * FROM post_replies WHERE post_id = :post_id";
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();

        $replies = [];
        $iter = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reply = new PostReply(
                $row['reply_id'],
                $row['post_id'],
                $row['user_id'],
                $row['content'],
                $row['created_at']
            );
            $replies[$iter++] = $reply;
        }

        return $replies;
    }

    public function addPostReply($post_id, $user_id, $content) {
        $query = "INSERT INTO post_replies (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
        $stmt = $this->database->connect()->prepare($query);

        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        $stmt->execute();
    }
}