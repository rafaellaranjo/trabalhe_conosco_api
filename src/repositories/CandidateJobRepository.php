<?php
require_once './Repository.php';

class CandidateJobRepository extends Repository {
    private static $instance;

    public function __construct() {
        parent::__construct();
    }

    protected function tableName() {
        return 'candidate_job';
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new CandidateJobRepository();
        }
        return self::$instance;
    }
}
?>
