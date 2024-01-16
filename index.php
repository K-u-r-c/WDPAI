<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::post('register', 'SecurityController');
Router::post('login', 'SecurityController');
Router::post('forum', 'ForumController');
Router::post('user_settings', 'SecurityController');
Router::post('forum_post', 'ForumPostController');
Router::post('change_user_settings', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('search', 'ForumController');

Router::run($path);