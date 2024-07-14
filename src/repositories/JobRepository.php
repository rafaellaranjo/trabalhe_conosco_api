<?php
require_once './Repository.php';

class JobRepository extends Repository {
    private static $instance;

    public function __construct() {
        parent::__construct();
    }

    protected function tableName() {
        return 'jobs';
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new JobRepository();
        }
        return self::$instance;
    }
}
?>
