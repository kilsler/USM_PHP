<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="https://cdn4.iconfinder.com/data/icons/cooking-155/512/01_Recipe_Book_Recipe_Ingredients_Book_Cook_Ingredient-1024.png">
    <title>Recipes.org</title>
</head>
<header class=" bg-warning pt-3 text-black">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="text-white m-0">Recipes.org</h1>
        <div class="absolute top-0 end-0 mt-3 me-3 ">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="<?= '/' ?>" class="nav-link text-black <?php if (preg_match('#^/\?(page=\d+)?$#', $_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') echo 'active'; ?>">Главная страница</a>
                </li>
                <li class="nav-item">
                    <a href="<?= '/recipe/create' ?>" class=" nav-link text-black <?php if ($_SERVER['REQUEST_URI'] === '/recipe/create') echo 'active'; ?>">Новый рецепт</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<body class="text-bg-dark  text-center text-black min-vh-75">
    <?= $content ?>
</body>

<div class="container d-flex justify-content-between align-items-center">
    <div class="text-center mt-4 mb-4 w-100 text-white">
        <p>@<?php echo date("Y-m-d")  ?></p>
    </div>
</div>

</html>