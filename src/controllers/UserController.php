<?php
require_once './Controller.php';
require_once '../models/UserModel.php';

class UserController extends Controller {
    public function __construct() {
        parent::__construct($this->getModelClass());
    }

    protected function getModelClass() {
        return 'User';
    }
}
?>
