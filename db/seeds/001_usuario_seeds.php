<?php

function seed($pdo)
{
    $users = [
        ['username' => 'admin', 'email' => 'admin@example.com', 'password' => 'admin_password', 'tipo' => 'admin'],
        ['username' => 'user1', 'email' => 'user1@example.com', 'password' => 'password1', 'tipo' => 'candidate'],
        ['username' => 'user2', 'email' => 'user2@example.com', 'password' => 'password2', 'tipo' => 'candidate'],
        ['username' => 'user3', 'email' => 'user3@example.com', 'password' => 'password3', 'tipo' => 'candidate'],
        ['username' => 'user4', 'email' => 'user4@example.com', 'password' => 'password4', 'tipo' => 'candidate']
    ];

    foreach ($users as $user) {
        $stmt = $pdo->prepare("INSERT INTO user (username, email, password, tipo) VALUES (:username, :email, :password, :tipo)");
        $stmt->execute([
            'username' => $user['username'],
            'email' => $user['email'],
            'password' => $user['password'],
            'tipo' => $user['tipo']
        ]);
    }
}

?>
