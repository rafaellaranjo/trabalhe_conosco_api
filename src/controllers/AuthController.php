<?php
require_once './Controller.php';
require_once '../models/UserModel.php';

class AuthController extends Controller {
    public function __construct() {
        parent::__construct($this->getModelClass());
    }

    protected function getModelClass() {
        return 'User';
    }

    public function signin(array $data) {
        try {
            $this->model->validate();
            $saved = $this->model->signin($data);
            http_response_code(200);
            return ['message' => 'Resource created successfully', 'data' => $saved];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to create resource: ' . $e->getMessage()];
        }
    }
}
?>
