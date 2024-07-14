<?php
require_once 'Model.php';

class Job extends Model {
    public $id;
    public $title;
    public $description;
    public $hiring_model;
    public $requirements;
    public $benefits;
    public $salary;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct(array $data = []) {
        parent::__construct($data);
        $this->fill($data);
    }

    public function validate() {
        if (!isset($this->title) || empty($this->title)) {
            throw new Exception("Title is required.");
        }

        if (!isset($this->hiring_model) || !HiringModel::tryFrom($this->hiring_model)) {
            throw new Exception("Invalid hiring model. Must be 'CLT', 'PJ', or 'Freelancer'.");
        }
    }

    public function exists() {
        return isset($this->id) && $this->repository->findById($this->id) !== false;
    }
}
?>