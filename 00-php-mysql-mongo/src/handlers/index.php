<?php
require_once __DIR__ . '/../db.php';
$recipes = getAllRecipes();
$page;
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
