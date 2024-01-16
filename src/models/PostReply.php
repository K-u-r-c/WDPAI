<?php

class PostReply {
    private $reply_id;
    private $post_id;
    private $user_id;
    private $content;
    private $created_at;

    public function __construct (int $reply_id, int $post_id, int $user_id, string $content, string $created_at) {
        $this->reply_id = $reply_id;
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    public function getId() : int {
        return $this->reply_id;
    }

    public function setId(int $reply_id): void {
        $this->reply_id = $reply_id;
    }

    public function getPostId() : int {
        return $this->post_id;
    }

    public function setPostId(int $post_id): void {
        $this->post_id = $post_id;
    }

    public function getUserId() : int {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }

    public function getContent() : string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function getDate() : string {
        return $this->created_at;
    }

    public function setDate(string $created_at): void {
        $this->$created_at = $created_at;
    }
}