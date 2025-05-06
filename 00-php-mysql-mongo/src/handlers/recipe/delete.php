<?php
require_once __DIR__ . '/../../db.php';
if (getRecipeById($id)) {
    $result = deleteRecipe($id);
} else {
    $result = false;
}
if ($recipe === false) {
    header('Location: /error');
}
