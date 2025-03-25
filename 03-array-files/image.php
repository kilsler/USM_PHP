<?php 
define('PROJECT','Test');
require_once'./components/header.php';

// Задаем путь к папке с изображениями
$dir = 'image/';
// Сканируем содержимое директории
// scandir — Получает список файлов и каталогов, расположенных по  указанному пути.
// Возвращает array, содержащий имена файлов и каталогов, расположенных по  пути, переданному в параметре
$files = scandir($dir);

// Если нет ошибок при сканировании
if ($files === false) {
   return;
}
$paths = [];
for ($i = 0; $i < count($files); $i++) {
   // Пропускаем текущий каталог и родительский
   if (($files[$i] != ".") && ($files[$i] != "..")) {
       // Получаем путь к изображению
       $paths[] = $dir . $files[$i]; 
   }
}

?>
<div class="container w-60 mx-auto mt-5 p-4 border rounded  d-flex align-content-around flex-wrap">
    <?php foreach($paths as $path): ?>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" style="height: 18rem;object-fit: cover; " src=<?= $path ?> alt="Card image cap">
        </div>    
    <?php endforeach; ?>
</div>











<?php  require_once'./components/footer.php'; ?>