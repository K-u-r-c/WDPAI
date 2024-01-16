<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../repository/UserRepository.php';

class SecurityController extends AppController {
    const UPLOAD_DIRECTORY = '/../public/images/user_profiles/';

    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login() {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        try {
            $user = $this->userRepository->getUser($email);

            if (!$user) {
                return $this->render('login', ['messages' => ['User with this email does not exist!']]);
            }

            if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
            }
        } catch (Exception $e) {
            return $this->render('login', ['messages' => ['An error occurred while retrieving user data']]);
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_email'] = $user->getEmail();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/forum");
    }

    public function register() {
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['username'];
        $repeatedPassword = $_POST['repeat-password'];

        if ($password !== $repeatedPassword) {
            return $this->render('register', ['messages' => ['Please provide proper password']]);
        }

        $user = new User($email, password_hash($password, PASSWORD_DEFAULT), $name, false);

        $this->userRepository->addUser($user);

        return $this->render('register', ['messages' => ['You\'ve been succesfully registrated!']]);
    }

    public function change_user_settings() {
        if ($this->isPost()) {
            $user_id = $_POST['id_user'] ?? null;
            $password = $_POST['password'] ?? null;
            $repeatedPassword = $_POST['confirm-password'] ?? null;
 
            if ($password !== null && $repeatedPassword !== null && trim($password) !== '' && trim($repeatedPassword) !== '') {
                
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $this->userRepository->changePassword($user_id, $hashedPassword);
            }

            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                move_uploaded_file(
                    $_FILES['file']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
                );

                $profileImagePath = $_FILES['file']['name'];

                $this->userRepository->changeProfilePicture($user_id, $profileImagePath);
            }
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/user_settings");
        exit();
    }

    public function user_settings() {
        $this->render('user_settings');
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION = array();

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
            exit();
        }
    }
}