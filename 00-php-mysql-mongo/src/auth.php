<?php
require_once __DIR__ . '/db.php';

function generateToken(): string
{
    return bin2hex(random_bytes(32));
}

function login(string $login, string $password): ?string
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $token = generateToken();
        $update = $pdo->prepare("UPDATE users SET token = ? WHERE id = ?");
        $update->execute([$token, $user['id']]);
        setcookie('user_id', $user['id'], time() + 3600, '/');
        setcookie('auth_token', $token, time() + 3600, '/');
        return $token;
    }

    return null;
}


function logout(): void
{
    if (!isset($_COOKIE['auth_token'])) return;

    $pdo = getConnection();
    $stmt = $pdo->prepare("UPDATE users SET token = NULL WHERE token = ?");
    $stmt->execute([$_COOKIE['auth_token']]);
    setcookie('auth_token', '', time() - 3600, '/');
}

function getCurrentUser(): ?array
{
    if (!isset($_COOKIE['auth_token'])) return null;

    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$_COOKIE['auth_token']]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
