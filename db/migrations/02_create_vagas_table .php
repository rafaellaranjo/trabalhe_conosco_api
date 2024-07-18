<?php

function migrate($pdo)
{
    $query = "CREATE TABLE IF NOT EXISTS jobs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        contract_model TEXT CHECK(contract_model IN ('CLT', 'PJ', 'Freelancer')) NOT NULL,
        requirements TEXT NOT NULL,
        benefits TEXT NOT NULL,
        remuneration REAL NOT NULL,
        status TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );";
    $pdo->exec($query);
}
?>
