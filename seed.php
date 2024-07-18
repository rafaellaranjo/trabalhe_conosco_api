<?php

require 'config/Database.php';

try {
    $db = Database::getInstance();
    $db->runSeeds(__DIR__ . '/db/seeds');
    $db->close();
} catch (Exception $e) {
    echo "Erro ao executar as seeds: " . $e->getMessage() . "\n";
}
?>
