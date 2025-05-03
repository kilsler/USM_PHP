<?php
require_once __DIR__ . '/../src/helpers.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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
        renderPage('recipe/create');
        break;
    default:
        renderPage('error');
        break;
}
?>
<script src="/js/comment.js"></script>