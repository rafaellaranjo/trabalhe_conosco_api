<?php
require_once '../repositories/Repository.php';

abstract class Model {
    protected $data = [];
    protected $repository;


    public function __construct(array $data = []) {
        $this->data = $data;
        $this->repository = new Repository();
    }

    public function create() {
        return $this->repository->create($this->data);
    }

    public function update($id) {
        return $this->repository->update($id, $this->data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }

    public function deleteMultiple(array $ids) {
        return $this->repository->deleteMultiple($ids);
    }

    public function find($limit = 20, $offset = 0, $orderBy = 'id', $orderDir = 'ASC') {
        return $this->repository->find($this->data, $limit, $offset, $orderBy, $orderDir);
    }

    public function findById($id) {
        return $this->repository->findById($id);
    }

    public function findAll($limit = 20, $offset = 0, $orderBy = 'id', $orderDir = 'ASC') {
        return $this->repository->findAll($limit, $offset, $orderBy, $orderDir);
    }

    public function fill(array $data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray() {
        return get_object_vars($this);
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

    abstract public function validate();

    abstract public function exists();

    public function save() {
        if ($this->exists()) {
            return $this->update($this->data['id']);
        } else {
            return $this->create();
        }
    }
}
?>
