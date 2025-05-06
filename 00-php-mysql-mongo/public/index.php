<?php

require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/auth.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$user = getCurrentUser();

if ($uri === '/login' && $method === 'GET') {
    renderPage('auth/login', ['user' => $user]);
    exit;
}

if ($uri === '/login' && $method === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $token = login($login, $password);
    if ($token) {
        header('Location: /');
        exit;
    } else {
        renderPage('auth/login', ['error' => 'Неверный логин или пароль', 'user' => null]);
        exit;
    }
}

if ($uri === '/logout') {
    logout();
    header('Location: /login');
    exit;
}

if (preg_match('#^/recipe/(\d+)$#', $uri, $matches)) {
    $id = (int)$matches[1];
    renderPage('recipe/index', ['id' => $id]);
    exit;
}

if (preg_match('#^/recipe/(\d+)/delete$#', $uri, $matches)) {
    $id = (int)$matches[1];
    renderPage('recipe/delete', ['id' => $id]);
    exit;
}

if (preg_match('#^/recipe/(\d+)/edit$#', $uri, $matches)) {
    $id = (int)$matches[1];
    renderPage('recipe/edit', ['id' => $id]);
    exit;
}

switch ($uri) {
    case '/':
    case '/home':
        renderPage('index');
        break;
    case '/error':
        renderPage('error');
        break;
    case '/recipe/create':
        if (getCurrentUser()) {
            renderPage('recipe/create');
        } else {
            header('Location: /login');
            exit;
        }
        break;
    default:
        renderPage('error');
        break;
}
?>
<script src="/js/comment.js"></script>