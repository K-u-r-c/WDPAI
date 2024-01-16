<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Post.php';

class PostRepository extends Repository {
    public function getPost($postId) {
        $query = "SELECT * FROM posts WHERE post_id = :id";
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPosts() : array {
        $query = "SELECT * FROM posts_with_user_image";
        $stmt = $this->database->connect()->prepare($query);
        $stmt->execute();

        $posts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post = new Post(
                $row['post_id'],
                $row['status'],
                $row['title'],
                $row['replies'],
                $row['views'],
                $row['user_id'],
                $row['post_created_at'],
                $row['content']
            );

            $post->setUserImage($row['profile_image_path']);

            $posts[] = $post;
        }

        return $posts;
    }

    public function addPost($post_title, $content, $user_id) {
        $status = 'open';
        $replies = 0;
        $views = 0;
        $forum_type = 'General';

        $query = "INSERT INTO posts (status, title, replies, views, user_id, content, forum_type) VALUES (:status, :title, :replies, :views, :user_id, :content, :forum_type)";
        $stmt = $this->database->connect()->prepare($query);

        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':title', $post_title, PDO::PARAM_STR);
        $stmt->bindParam(':replies', $replies, PDO::PARAM_INT);
        $stmt->bindParam(':views', $views, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':forum_type', $forum_type, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function deletePost($postId) {
        $query = "DELETE FROM posts WHERE post_id = :id";
        $statement = $this->database->connect()->prepare($query);
        $statement->bindParam(':id', $postId, PDO::PARAM_INT);
        $statement->execute();
    }

    public function getPostsByTitle(string $title) {
        $query = "SELECT * FROM posts_with_user_image WHERE title LIKE :title";
        $stmt = $this->database->connect()->prepare($query);
        $stmt->bindValue(':title', "%$title%", PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>