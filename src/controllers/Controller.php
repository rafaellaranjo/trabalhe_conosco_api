<?php
abstract class Controller {
    protected $model;

    public function __construct($modelClass) {
        $this->model = new $modelClass();
    }

    abstract protected function getModelClass();

    public function find(array $data, $limit = 20, $page = 1, $orderBy = 'id', $orderDir = 'ASC') {
        try {
            $offset = ($page - 1) * $limit;
            $this->model->fill($data);
            $result = $this->model->find($data, $limit, $offset, $orderBy, $orderDir);
            http_response_code(200);
            return ['data' => $result];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to fetch data: ' . $e->getMessage()];
        }
    }

    public function findAll($limit = 20, $page = 1, $orderBy = 'id', $orderDir = 'ASC') {
        try {
            $offset = ($page - 1) * $limit;
            $result = $this->model->findAll($limit, $offset, $orderBy, $orderDir);
            http_response_code(200);
            return ['data' => $result];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to fetch data: ' . $e->getMessage()];
        }
    }

    public function findById($id) {
        try {
            $result = $this->model->findById($id);
            if ($result) {
                http_response_code(200);
                return ['data' => $result];
            } else {
                http_response_code(404);
                return ['error' => 'Resource not found'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to fetch data: ' . $e->getMessage()];
        }
    }

    public function create(array $data) {
        try {
            $this->model->fill($data);
            $this->model->validate();
            $saved = $this->model->save();
            http_response_code(200);
            return ['message' => 'Resource created successfully', 'data' => $saved];
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to create resource: ' . $e->getMessage()];
        }
    }

    public function update($id, array $data) {
        try {
            $this->model->fill($data);
            $updated = $this->model->update($id, $data);
            if ($updated) {
                http_response_code(200);
                return ['message' => 'Resource updated successfully'];
            } else {
                http_response_code(404);
                return ['error' => 'Failed to update resource'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to update resource: ' . $e->getMessage()];
        }
    }

    public function delete($id) {
        try {
            $deleted = $this->model->delete($id);
            if ($deleted) {
                http_response_code(200);
                return ['message' => 'Resource deleted successfully'];
            } else {
                http_response_code(404);
                return ['error' => 'Failed to delete resource'];
            }
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => 'Failed to delete resource: ' . $e->getMessage()];
        }
    }

}

?>
