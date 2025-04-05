<?php
session_start();

// Handle CSRF token request (API endpoint)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['get_csrf'])) {
    header('Content-Type: application/json');
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo json_encode(['token' => $_SESSION['csrf_token']]);
    exit;
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token first
    if (!isset($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location: signin.html?error=invalid");
        exit;
    }

    $usersFile = 'users.json';
    $users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

    $action = $_POST['action'] ?? '';
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    // Validate inputs
    if (empty($email)) || empty($password)) {
        header("Location: signin.html?error=empty");
        exit;
    }

    if ($action === 'signup') {
        $lastName = trim($_POST['last_name'] ?? '');
        if (empty($lastName)) {
            header("Location: signin.html?error=empty");
            exit;
        }

        // Check if user exists
        foreach ($users as $user) {
            if (strtolower($user['email']) === $email) {
                header("Location: signin.html?error=exists");
                exit;
            }
        }

        // Add new user
        $users[] = [
            'last_name' => htmlspecialchars($lastName),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
        $_SESSION['email'] = $email;
        header("Location: account.html");
        exit;
    } 
    elseif ($action === 'login') {
        foreach ($users as $user) {
            if (strtolower($user['email']) === $email && password_verify($password, $user['password'])) {
                $_SESSION['email'] = $email;
                header("Location: account.html");
                exit;
            }
        }
        header("Location: signin.html?error=invalid");
        exit;
    }
}

// Fallback for invalid requests
header("Location: signin.html?error=invalid");
?>
