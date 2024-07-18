<?php

function seed($pdo)
{
    $candidateJobs = [
        ['job_id' => 1, 'candidate_id' => 1, 'status' => 'applied'],
        ['job_id' => 2, 'candidate_id' => 2, 'status' => 'applied'],
        ['job_id' => 3, 'candidate_id' => 3, 'status' => 'applied'],
        ['job_id' => 4, 'candidate_id' => 4, 'status' => 'applied'],
        ['job_id' => 5, 'candidate_id' => 5, 'status' => 'applied']
    ];

    foreach ($candidateJobs as $candidateJob) {
        $stmt = $pdo->prepare("INSERT INTO candidate_job (job_id, candidate_id, status) VALUES (:job_id, :candidate_id, :status)");
        $stmt->execute([
            'job_id' => $candidateJob['job_id'],
            'candidate_id' => $candidateJob['candidate_id'],
            'status' => $candidateJob['status']
        ]);
    }
}

?>
