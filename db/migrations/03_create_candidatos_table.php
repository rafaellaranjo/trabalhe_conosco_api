<?php

function migrate($pdo)
{
    $query = "CREATE TABLE IF NOT EXISTS candidate (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        resume TEXT NOT NULL,
        age INTEGER NOT NULL,
        city TEXT NOT NULL,
        address TEXT NOT NULL,
        marital_status TEXT NOT NULL,
        phone TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES user(id)
    );";
    $pdo->exec($query);
}
?>
