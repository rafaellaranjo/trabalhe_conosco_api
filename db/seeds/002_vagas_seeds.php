<?php

function seed($pdo)
{
    $jobs = [
        ['title' => 'Software Engineer', 'description' => 'Development of web applications', 'contract_model' => 'CLT', 'requirements' => 'Experience with PHP and JavaScript', 'benefits' => 'Health insurance, Meal voucher', 'remuneration' => 6000, 'status' => 'open'],
        ['title' => 'Project Manager', 'description' => 'Management of software development projects', 'contract_model' => 'PJ', 'requirements' => 'Experience in project management', 'benefits' => 'Flexible schedule', 'remuneration' => 8000, 'status' => 'open'],
        ['title' => 'UX Designer', 'description' => 'Design of user interfaces', 'contract_model' => 'Freelancer', 'requirements' => 'Experience with design tools', 'benefits' => 'Remote work', 'remuneration' => 5000, 'status' => 'open'],
        ['title' => 'Data Analyst', 'description' => 'Analysis of data sets', 'contract_model' => 'CLT', 'requirements' => 'Experience with data analysis', 'benefits' => 'Health insurance', 'remuneration' => 5500, 'status' => 'open'],
        ['title' => 'DevOps Engineer', 'description' => 'Management of CI/CD pipelines', 'contract_model' => 'PJ', 'requirements' => 'Experience with DevOps tools', 'benefits' => 'Stock options', 'remuneration' => 7000, 'status' => 'open']
    ];

    foreach ($jobs as $job) {
        $stmt = $pdo->prepare("INSERT INTO jobs (title, description, contract_model, requirements, benefits, remuneration, status) VALUES (:title, :description, :contract_model, :requirements, :benefits, :remuneration, :status)");
        $stmt->execute([
            'title' => $job['title'],
            'description' => $job['description'],
            'contract_model' => $job['contract_model'],
            'requirements' => $job['requirements'],
            'benefits' => $job['benefits'],
            'remuneration' => $job['remuneration'],
            'status' => $job['status']
        ]);
    }
}

?>
