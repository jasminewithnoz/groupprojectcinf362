<?php
session_start();

$usersFile = 'users.json';
$users = file_exists($usersFile) ? json_decode(file_get_contents($usersFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($action === 'signup') {
        
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                header("Location: signin.html?error=email_exists");
                exit();
            }
        }

        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $users[] = [
            'last_name' => $last_name,
            'email' => $email,
            'password' => $hashed_password
        ];
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

        
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        header("Location: account.php");
        exit();
    }

    if ($action === 'login') {
        foreach ($users as $user) {
            if ($user['email'] === $email && password_verify($password, $user['password'])) {
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                header("Location: account.php");
                exit();
            }
        }
        header("Location: signin.html?error=invalid_credentials");
        exit();
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.html");
    exit();
}
?>