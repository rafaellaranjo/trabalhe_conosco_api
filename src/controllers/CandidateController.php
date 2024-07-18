<?php
require_once './Controller.php';
require_once '../models/Candidate.php';

class CandidateController extends Controller {
    public function __construct() {
        parent::__construct($this->getModelClass());
    }

    protected function getModelClass() {
        return 'candidate';
    }
}
?>
