<?php
require_once 'Model.php';
require_once './src/repositories/UserRepository.php';

class User extends Model {
    protected $userRepository;

    public $id;
    public $username;
    public $email;
    public $password;
    public $tipo;
    public $created_at;
    public $updated_at;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this->fill($data);
        $this->userRepository = new UserRepository();
    }

    public function validate() {
        if (empty($this->username) || empty($this->email)) {
            throw new Exception("Username and email are required.");
        }
    }

    public function exists() {
        return isset($this->id) && $this->repository->findById($this->id) !== false;
    }

    public function signin($data) {
        $username = $data['username'];
        $password = $data['password'];
        return $this->userRepository->signin($username, $password);
    }
}
?>
