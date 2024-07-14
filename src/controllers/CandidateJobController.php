<?php
require_once './Controller.php';
require_once '../models/CandidateJob.php';

class CandidateJobController extends Controller {
    public function __construct() {
        parent::__construct($this->getModelClass());
    }

    protected function getModelClass() {
        return 'candidate_job';
    }
}
?>

