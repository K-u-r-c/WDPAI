<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/Post.php';
require_once __DIR__ .'/../repository/PostRepository.php';

class ForumController extends AppController {
    private $postRepository;

    public function __construct() {
        parent::__construct();
        $this->postRepository = new PostRepository();
    }

    public function forum() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? null;
            $content = $_POST['content'] ?? null;
            $user_id = $_POST['user_id'] ?? null;

            if ($title !== null && $content !== null && $user_id !== null && !empty(trim($title)) && !empty(trim($content))) {
                $this->postRepository->addPost($title, $content, $user_id);

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/forum");
                exit;
            }

            $postId = $_POST['post_id'] ?? null;
            if (isset($postId)) {
                $this->postRepository->deletePost($postId);

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/forum");
                exit;
            }
        }

        $this->render('forum');
    }

    public function search() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->postRepository->getPostsByTitle($decoded['search']));

            //$this->render('forum', ['posts' => $posts]);
        }
    }
}