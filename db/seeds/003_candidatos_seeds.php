<?php

function seed($pdo)
{
    $candidates = [
        ['user_id' => 2, 'resume' => 'Experienced software engineer', 'age' => 30, 'city' => 'New York', 'address' => '123 Main St', 'marital_status' => 'Single', 'phone' => '555-1234'],
        ['user_id' => 3, 'resume' => 'Project manager with 10 years of experience', 'age' => 40, 'city' => 'San Francisco', 'address' => '456 Market St', 'marital_status' => 'Married', 'phone' => '555-5678'],
        ['user_id' => 4, 'resume' => 'Creative UX designer', 'age' => 25, 'city' => 'Los Angeles', 'address' => '789 Sunset Blvd', 'marital_status' => 'Single', 'phone' => '555-8765'],
        ['user_id' => 5, 'resume' => 'Data analyst with a strong background in statistics', 'age' => 35, 'city' => 'Chicago', 'address' => '101 State St', 'marital_status' => 'Married', 'phone' => '555-3456'],
        ['user_id' => 6, 'resume' => 'DevOps engineer with experience in AWS and Docker', 'age' => 28, 'city' => 'Seattle', 'address' => '202 Pine St', 'marital_status' => 'Single', 'phone' => '555-6543']
    ];

    foreach ($candidates as $candidate) {
        $stmt = $pdo->prepare("INSERT INTO candidate (user_id, resume, age, city, address, marital_status, phone) VALUES (:user_id, :resume, :age, :city, :address, :marital_status, :phone)");
        $stmt->execute([
            'user_id' => $candidate['user_id'],
            'resume' => $candidate['resume'],
            'age' => $candidate['age'],
            'city' => $candidate['city'],
            'address' => $candidate['address'],
            'marital_status' => $candidate['marital_status'],
            'phone' => $candidate['phone']
        ]);
    }
}

?>
