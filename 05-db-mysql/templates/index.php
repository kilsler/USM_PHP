<?php
require_once __DIR__ . '/../src/handlers/index.php';
?>

<?php for ($i = $page * 3; $i > ($page * 3) - 3; $i--): ?>
    <?php if ($i > count($recipes)) {
        continue;
    } ?>
    <div href="#" class="list-group-item list-group-item-action flex-column align-items-start mt-3 mb-3 container w-50 p-3 border rounded shadow-sm bg-light flex flex-column gap-3 ">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?php echo  $recipes[$i - 1]['title'] ?></h5>
            <small></small>
        </div>
        <p class="mb-1">Описание: <?php echo $recipes[$i - 1]['description']; ?></p>
        <p>Тэги: <?php echo  $recipes[$i - 1]['tags'] ?></p>
        <p>Категории: <?php echo $recipes[$i - 1]['name']; ?></p>
        <p>Ингридиенты: <?php echo $recipes[$i - 1]['ingredients']; ?></p>

        <a class="btn btn-primary mt-2" href="/recipe/<?php echo $recipes[$i - 1]['id'] ?>">Посмотреть рецепт</a>
    </div>
<?php endfor; ?>


<ul class="pagination justify-content-center">
    <li class="page-item <?php if ($page == 1) echo 'disabled' ?>">
        <a class="page-link" href="<?php echo "/" . "?page=" . ($page - 1) ?>" <?php if ($page == 1) echo 'disabled' ?>>Prev Page</a>

    </li>
    <li class="page-item <?php if ($page == ceil((count($recipes) / 3))) echo 'disabled' ?>">
        <a class="page-link" href="<?php echo "/" . "?page=" . ($page + 1) ?>" <?php if ($page == 3) echo 'disabled' ?>>Next Page</a>
    </li>
</ul>