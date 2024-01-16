<?php

class User {
    private $id_user;
    private $email;
    private $password;
    private $name;
    private $profile_image_path;
    private $isAdmin;

    public function __construct (string $email, string $password, string $name, bool $isAdmin) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->isAdmin = $isAdmin;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getProfileImagePath() {
        return $this->profile_image_path;
    }

    public function setProfileImagePath($profile_image_path) {
        $this->profile_image_path = $profile_image_path;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }
}