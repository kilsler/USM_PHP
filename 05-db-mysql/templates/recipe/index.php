<?php
require_once __DIR__ . '/../../src/handlers/recipe/index.php';
?>
<div href="#" class="list-group-item list-group-item-action flex-column align-items-start mt-3 mb-3 container w-50 p-3 border rounded shadow-sm bg-light flex flex-column gap-3 ">
    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1"><?php echo  $recipe['title'] ?></h5>
    </div>
    <p class="mb-1">Описание: <?php echo $recipe['description']; ?></p>
    <p>Тэги: <?php echo join(', ', $recipe['tags']) ?></p>
    <p>Категории: <?php echo $recipe['name']; ?></p>
    <p>Ингридиенты: <?php echo $recipe['ingredients']; ?></p>
    <p>Шаги приготовления:</p>
    <ul class="list-group">
        <?php foreach ($recipe['steps'] as $step): ?>
            <li class="list-group-item"><?php echo $step; ?></li>
        <?php endforeach; ?>
    </ul>
    <div class="justify-content-between">
        <a class="btn btn-primary mt-2" href="/recipe/<?php echo $recipe['id'] ?>/edit">Изменить рецепт</a>
        <a class="btn btn-danger mt-2" href="/recipe/<?php echo $recipe['id'] ?>/delete">Удалить рецепт</a>
    </div>
</div>