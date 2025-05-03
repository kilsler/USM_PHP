<?php
require_once __DIR__ . '/../../db.php';
$recipe = getRecipeById($id);
if ($recipe === false) {
    header('Location: /error');
}
$recipe['steps'] = explode('|', $recipe['steps']);
$recipe['tags'] = explode(',', $recipe['tags']);
