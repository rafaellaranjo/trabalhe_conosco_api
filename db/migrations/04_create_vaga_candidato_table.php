<?php

function migrate($pdo)
{
    $query = "CREATE TABLE IF NOT EXISTS candidate_job (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        job_id INTEGER NOT NULL,
        candidate_id INTEGER NOT NULL,
        status TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (job_id) REFERENCES jobs(id),
        FOREIGN KEY (candidate_id) REFERENCES candidate(id)
    );";
    $pdo->exec($query);
}
?>
