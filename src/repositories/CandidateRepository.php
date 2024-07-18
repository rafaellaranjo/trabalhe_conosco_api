<?php
require_once './Repository.php';

class CandidateRepository extends Repository {
    private static $instance;

    public function __construct() {
        parent::__construct();
    }

    protected function tableName() {
        return 'candidates';
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new CandidateRepository();
        }
        return self::$instance;
    }
}
?>
