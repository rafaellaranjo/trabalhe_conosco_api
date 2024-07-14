<?php
require_once 'Model.php';

class User extends Model {
    public $id;
    public $username;
    public $email;
    public $password;
    public $tipo;
    public $created_at;
    public $updated_at;

    public function validate() {
        if (empty($this->username) || empty($this->email)) {
            throw new Exception("Username and email are required.");
        }
    }

    public function exists() {
        return isset($this->id) && $this->repository->findById($this->id) !== false;
    }
}
?>
