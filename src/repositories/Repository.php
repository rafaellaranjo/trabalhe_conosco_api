<?php
require_once '../../config/Database.php';

abstract class Repository {
    protected $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    abstract protected function tableName();

    public function create($data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $stmt = $this->conn->prepare("INSERT INTO {$this->tableName()} ($fields) VALUES ($placeholders)");
        $stmt->execute($data);
        return $this->conn->lastInsertId();
    }

    public function update($id, array $data) {
        $setClause = [];
        $currentDateTime = new DateTime();
        $data['updated_at'] = $currentDateTime->format('Y-m-d H:i:s'); 

        foreach ($data as $key => $value) {
            $setClause[] = "$key = :$key";
        }
        $setClause = implode(', ', $setClause);
        $data['id'] = $id;
        $stmt = $this->conn->prepare("UPDATE {$this->tableName()} SET $setClause WHERE id = :id");
        $stmt->execute($data);

        return $stmt->rowCount() > 0;
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->tableName()} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll($limit = 20, $offset = 0, $orderBy = 'id', $orderDir = 'ASC') {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->tableName()} ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($data = [], $limit = 20, $offset = 0, $orderBy = 'id', $orderDir = 'ASC') {
        $whereClause = '';
        $values = [];
        if (!empty($data)) {
            $whereClause = 'WHERE ';
            foreach ($data as $key => $value) {
                $whereClause .= "$key = ? AND ";
                $values[] = $value;
            }
            $whereClause = rtrim($whereClause, 'AND ');
        }
    
        $stmt = $this->conn->prepare("SELECT * FROM {$this->tableName()} $whereClause ORDER BY $orderBy $orderDir LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute($values);
    
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->tableName()} WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public function deleteMultiple(array $ids) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->conn->prepare("DELETE FROM {$this->tableName()} WHERE id IN ($placeholders)");
        $stmt->execute($ids);
    }
}
?>
