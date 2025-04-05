<?php
session_start();
header('Content-Type: application/json'); // For clean error handling

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

// After defining $usersFile
if (!is_writable($usersFile) && file_exists($usersFile)) {
    die(json_encode(['error' => 'Server configuration error']));
}

// Get form data
$action = $_POST['action'];
$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];
$last_name = $_POST['last_name'] ?? '';

// Validate
if (empty($email) || empty($password)) {
    die(json_encode(['error' => 'Email and password required']));
}

if ($action === 'signup') {
    // Check if user exists
    foreach ($users as $user) {
        if (strtolower($user['email']) === $email) {
            die(json_encode(['error' => 'Email already exists']));
        }
    }

    // Add new user
    $users[] = [
        'last_name' => $last_name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT) // Securely hash
    ];

    file_put_contents($usersFile, json_encode($users));
    $_SESSION['email'] = $email;
    echo json_encode(['success' => true, 'redirect' => 'account.html']);
} 
elseif ($action === 'login') {
    // Find user
    foreach ($users as $user) {
        if (strtolower($user['email']) === $email && 
            password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            echo json_encode(['success' => true, 'redirect' => 'account.html']);
            exit;
        }
    }
    echo json_encode(['error' => 'Invalid credentials']);
}
?>