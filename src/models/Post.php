<?php

class Post {
    private $post_id;
    private $status;
    private $title;
    private $replies;
    private $views;
    private $user_id;
    private $user_image;
    private $created_at;
    private $content;

    public function __construct($post_id, $status, $title, $replies, $views, $user_id, $created_at, $content) {
        $this->post_id = $post_id;
        $this->status = $status;
        $this->title = $title;
        $this->replies = $replies;
        $this->views = $views;
        $this->user_id = $user_id;
        $this->created_at = $created_at;
        $this->content = $content;
    }

    public function getId() {
        return $this->post_id;
    }

    public function setId($post_id) {
        $this->post_id = $post_id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getReplies() {
        return $this->replies;
    }

    public function setReplies($replies) {
        $this->replies = $replies;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;
    }

    public function getUserID() {
        return $this->user_id;
    }

    public function setUserID($author) {
        $this->user_id = $author;
    }

    public function getUserImage() {
        return $this->user_image;
    }

    public function setUserImage($user_image) {
        $this->user_image = $user_image;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
}

?>