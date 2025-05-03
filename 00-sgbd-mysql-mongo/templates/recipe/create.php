<?php
require_once __DIR__ . '/../../src/handlers/formHandler.php';
require_once __DIR__ . '/../../src/handlers/recipe/create.php';

handleCreateForm();
?>

<script>
    function addStep() {
        let stepContainer = document.querySelector("#steps-container");
        let stepItem = document.createElement("div");
        stepItem.classList.add("step-item", "mb-2");
        stepItem.innerHTML = `
                <input type="text" name="steps[]" placeholder="Введите шаг приготовления" required class="form-control mb-2">
                <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Удалить</button>
            `;
        stepContainer.appendChild(stepItem);
    }
</script>
<form action="" method="post" class="mb-3 mt-3 container w-50 p-3 border rounded shadow-sm bg-light flex flex-column gap-3 ">
    <h2>Добавление рецепта</h2>
    <div class="mb-3">
        <label class="form-label">Название рецепта:</label>
        <input class="form-control" type="text" name="title" required value="<?= isset($titlePost) ? htmlspecialchars($titlePost) : '' ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Категория:</label>
        <select class="form-select" name="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']) ?>"
                    <?php if (isset($categoryPost) && $categoryPost == $category['name']) echo 'selected' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Ингредиенты:</label>
        <textarea class="form-control" name="ingredients" required rows="5" value="" placeholder="Введите ингредиенты через запятую"><?= isset($ingredientsPost) ? htmlspecialchars(trim($ingredientsPost)) : '' ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Описание:</label>
        <textarea class="form-control" name="description" required rows="5" placeholder="Введите описание рецепта"><?= isset($descriptionPost) ? htmlspecialchars(preg_replace('/\s+/', ' ', trim($descriptionPost))) : '' ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Тэги:</label>
        <select class="form-select" name="tags[]" multiple>
            <?php foreach ($tags as $tag): ?>
                <option value="<?= htmlspecialchars($tag) ?>"
                    <?php if (isset($tagsPost) &&  in_array($tag, $tagsPost)) echo 'selected' ?>>
                    <?= htmlspecialchars($tag) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Шаги приготовления:</label>
        <?php if (isset($stepsPost) && is_array($stepsPost)) : ?>
            <div id="steps-container">
                <?php foreach ($stepsPost as $step): ?>
                    <div class="step-item mb-2">
                        <input type="text" name="steps[]" placeholder="Введите шаг приготовления" required class="form-control mb-2" value="<?= htmlspecialchars($step) ?>">
                        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Удалить</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div id="steps-container">
                <div class="step-item mb-2">
                    <input type="text" name="steps[]" placeholder="Введите шаг приготовления" required class="form-control mb-2">
                    <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Удалить</button>
                </div>
            </div>
        <?php endif; ?>

        <button class="btn btn-primary" type="button" onclick="addStep()">Добавить шаг</button>
    </div>
    <button class="btn btn-primary" type="submit">Отправить</button>
</form>