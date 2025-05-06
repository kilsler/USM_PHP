<?php
require_once __DIR__ . '/../../src/handlers/recipe/delete.php';
?>
<?php if ($result): ?>
    <div class="alert alert-success" role="alert">
        <h2 class="text-center mb-4">Рецепт успешно удален</h2>
    </div>
<?php else: ?>
    <div class="alert alert-danger" role="alert">
        <h2 class="text-center mb-4">Ошибка: Рецепта не существует</h2>
        <p class="text-center">Пожалуйста, попробуйте еще раз.</p>
    </div>
<?php endif; ?>
<div class="card">
    <div class="card-body text-center">
        <a class="btn btn-primary" href="/">Вернуься на главную</a>

    </div>
</div>