<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository {
    public function getLoggedInUser() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_email'])) {
            echo $_SESSION['user_email'];
            return null;
        }

        $userEmail = $_SESSION['user_email'];
        $query = $this->database->connect()->prepare('
            SELECT * FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id_user_details WHERE email = :userEmail
        ');
        $query->bindParam(':userEmail', $userEmail);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        $returnUser = new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['isAdmin']
        );

        $returnUser->setIdUser($user['id_user']);
        $returnUser->setProfileImagePath($user['profile_image_path']);

        return $returnUser;
    }
    
    public function getUser(string $email): ?User {
        try {
            $stmt = $this->database->connect()->prepare('
                SELECT * FROM users u LEFT JOIN users_details ud 
                ON u.id_user_details = ud.id_user_details WHERE email = :email
            ');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user == false) {
                throw new Exception("User not found: $email");
            }

            $returnUser = new User(
                $user['email'],
                $user['password'],
                $user['name'],
                $user['isAdmin']
            );

            $returnUser->setIdUser($user['id_user']);
            $returnUser->setProfileImagePath($user['profile_image_path']);

            return $returnUser;

        } catch (Exception $e) {
            return null;
        }
    }

    public function getUserById(int $id): ?User {
        try {
            $stmt = $this->database->connect()->prepare('
                SELECT * FROM users u LEFT JOIN users_details ud 
                ON u.id_user_details = ud.id_user_details WHERE u.id_user = :id
            ');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user == false) {
                throw new Exception("User not found: $id");
            }

            $returnUser = new User(
                $user['email'],
                $user['password'],
                $user['name'],
                $user['isAdmin']
            );

            $returnUser->setIdUser($user['id_user']);
            $returnUser->setProfileImagePath($user['profile_image_path']);

            return $returnUser;

        } catch (Exception $e) {
            return null;
        }
    }

    public function addUser(User $user) {
        $db = $this->database->connect();

        $stmt = $db->prepare('
            INSERT INTO users_details (name)
            VALUES (?)
        ');
        $stmt->execute([$user->getName()]);

        $lastUserDetailsId = $db->lastInsertId();

        $stmt = $db->prepare('
            INSERT INTO users (email, password, id_user_details)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([
            $user->getEmail(),
            $user->getPassword(),
            $lastUserDetailsId
        ]);

        $lastUserId = $db->lastInsertId();

        $stmt = $db->prepare('
            UPDATE users_details
            SET id_user = ?
            WHERE id_user_details = ?
        ');
        
        $stmt->execute([
            $lastUserId,
            $lastUserDetailsId
        ]);
    }

    public function changePassword($user_id, $password) {
        $query = "UPDATE users SET password = :password WHERE id_user = :user_id";
        $stmt = $this->database->connect()->prepare($query);

        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function changeProfilePicture($user_id, $profilePicturePath) {
        $query = "UPDATE users_details SET profile_image_path = :profilePicturePath WHERE id_user = :user_id";
        $stmt = $this->database->connect()->prepare($query);

        $stmt->bindParam(':profilePicturePath', $profilePicturePath, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();
    }
}