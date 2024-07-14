<?php
require_once 'Model.php';

class Candidate extends Model {
    public $id;
    public $user_id;
    public $resume;
    public $age;
    public $city;
    public $address;
    public $marital_status;
    public $phone;
    public $created_at;
    public $updated_at;

    public function validate() {
        // Implementação da validação específica para User
    }

    public function exists() {
        return isset($this->id) && $this->repository->findById($this->id) !== false;
    }
}
?>
