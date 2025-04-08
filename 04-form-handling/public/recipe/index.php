<?php
require_once __DIR__ . '/../../src/components/header.php';
$recipes = file(__DIR__.'/../../storage/recipes.txt', FILE_IGNORE_NEW_LINES);
$recipes = array_map('json_decode', $recipes);
$page;
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
?>

<?php for ($i = $page * 3; $i > ($page * 3) - 3; $i--): ?>
    <?php if ($i > count($recipes)) { continue; } ?>
    <div href="#" class="list-group-item list-group-item-action flex-column align-items-start mb-3 container w-50 p-3 border rounded shadow-sm bg-light flex flex-column gap-3 ">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo  $recipes[$i-1]->title ?></h5>
                <small></small>
            </div>
            <p class="mb-1">Описание: <?php echo $recipes[$i-1]->description; ?></p>
            <p>Тэги: <?php  echo join(', ',$recipes[$i-1]->tags) ?></p>
            <p>Категории: <?php echo $recipes[$i-1]->category; ?></p>
            <p>Ингридиенты: <?php echo $recipes[$i-1]->ingredients; ?></p>
            <p>Шаги приготовления:</p>
            <ul class="list-group">
                <?php foreach($recipes[$i-1]->steps as $step): ?>
                    <li class="list-group-item"><?php echo $step; ?></li>
                <?php endforeach; ?>
            </ul>
    </div>
    <?php endfor; ?>



<ul class="pagination justify-content-center">
    <li class="page-item <?php if($page == 1) echo 'disabled' ?>">
      <a class="page-link" href="<?php echo "/recipe/index.php"."?page=".($page-1) ?>" <?php if($page == 1) echo 'disabled' ?>>Prev Page</a>

    </li>
    <li class="page-item <?php if($page == ceil( (count($recipes)/3))) echo 'disabled' ?>">
      <a class="page-link" href="<?php  echo "/recipe/index.php"."?page=".($page+1) ?>" <?php if($page == 3) echo 'disabled' ?>>Next Page</a>
    </li>
  </ul>

<?php
require_once __DIR__ . '/../../src/components/footer.php';
?>
