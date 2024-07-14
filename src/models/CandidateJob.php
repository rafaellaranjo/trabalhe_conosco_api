<?php
require_once 'Model.php';

class CandidateJob extends Model {
    public $id;
    public $job_id;
    public $candidate_id;
    public $status;
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
