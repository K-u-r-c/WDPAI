<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Post.php';
require_once __DIR__ .'/../repository/PostReplyRepository.php';

class ForumPostController extends AppController {
    private $postReplyRepository;

    public function __construct() {
        parent::__construct();
        $this->postReplyRepository = new PostReplyRepository();
    }

    public function forum_post() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'] ?? null;
            $user_id = $_POST['user_id'] ?? null;
            $post_id = $_POST['post_id'] ?? null;

            if ($content !== null && $user_id !== null && $post_id !== null && !empty(trim($content))) {
                $this->postReplyRepository->addPostReply($post_id, $user_id, $content);

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/forum_post?post_id=$post_id");
                exit;
            }
        }

        $this->render('forum_post');
    }
}