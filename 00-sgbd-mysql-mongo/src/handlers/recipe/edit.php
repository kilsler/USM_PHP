<?php
$tags = ["Быстро", "Полезно", "Вегетарианское", "Праздничное"];
$categories = getAllCategories();
$recipe = getRecipeById($id);
if ($recipe === false) {
    header('Location: /error');
}
$recipe['steps'] = explode('|', $recipe['steps']);
handleEditForm();
