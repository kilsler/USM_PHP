<?php
require_once __DIR__ . '/../src/components/header.php';
$recipes = file(__DIR__.'/../storage/recipes.txt', FILE_IGNORE_NEW_LINES);
$recipes = array_map('json_decode', $recipes);
$latestRecipes = array_slice($recipes, -2);
?>
<div class="list-group container mt-5 mb-5">
    <h2 class="text-center mb-4">Последние рецепты</h2>
    <?php foreach ($latestRecipes as $recipe): ?>
        <div href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-3 container w-50 p-3 border rounded shadow-sm bg-light flex flex-column gap-3 ">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo  $recipe->title ?></h5>
                <small></small>
            </div>
            <p class="mb-1">Описание: <?php echo $recipe->description; ?></p>
            <p>Тэги: <?php  echo join(', ',$recipe->tags) ?></p>
            <p>Категории: <?php echo $recipe->category; ?></p>
            <p>Ингридиенты: <?php echo $recipe->ingredients; ?></p>
            <p>Шаги приготовления:</p>
            <ul class="list-group">
                <?php foreach($recipe->steps as $step): ?>
                    <li class="list-group-item"><?php echo $step; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
    <a href='/recipe/create.php' type="button" class="btn btn-primary w-50 container ">Добавить рецепт</a>
</div>

<?php
require_once __DIR__ . '/../src/components/footer.php';
?>
