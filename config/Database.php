<?php
class Database {
    private static $instance;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO('sqlite:/var/www/html/db/database.sqlite');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
            throw new Exception("Erro na conexão com o banco de dados. Por favor, tente novamente mais tarde.");
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        $this->conn = null;
    }

    public function runMigrations($migrationsDir) {
        $migrations = array_diff(scandir($migrationsDir), ['.', '..']);
        sort($migrations);

        foreach ($migrations as $migration) {
            require_once $migrationsDir . '/' . $migration;
            migrate($this->conn); // Chama a função migrate passando a conexão
            echo "Migration $migration executada com sucesso.\n";
        }

        echo "Todas as migrações foram concluídas.\n";
    }

    public function runSeeds($seedsDir) {
        $seeds = array_diff(scandir($seedsDir), ['.', '..']);
        sort($seeds);

        foreach ($seeds as $seed) {
            require_once $seedsDir . '/' . $seed;
            seed($this->conn); // Chama a função seed passando a conexão
            echo "Seed $seed executada com sucesso.\n";
        }

        echo "Todas as seeds foram concluídas.\n";
    }

    private function __clone() {}
}
?>
