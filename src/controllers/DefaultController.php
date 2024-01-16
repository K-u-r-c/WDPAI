<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function login()
    {
        $this->render('login');
    }

    public function register()
    {
        $this->render('register');
    }

    public function forum()
    {
        $this->render('forum');
    }

    public function user_settings()
    {
        $this->render('user_settings');
    }

    public function forum_post()
    {
        $this->render('forum_post');
    }
}