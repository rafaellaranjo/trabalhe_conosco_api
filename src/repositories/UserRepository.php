<?php
require_once './Repository.php';

class UserRepository extends Repository {
    private static $instance;

    public function __construct() {
        parent::__construct();
    }
    protected function tableName() {
        return 'user';
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function signin($username, $password) {
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        } else {
            return false;
        }
    }
}
?>
