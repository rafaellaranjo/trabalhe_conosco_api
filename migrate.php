<?php

require 'config/Database.php';

try {
    $db = Database::getInstance();
    $db->runMigrations(__DIR__ . '/db/migrations');
    $db->close();
} catch (Exception $e) {
    echo "Erro ao executar as migrações: " . $e->getMessage() . "\n";
}
?>
