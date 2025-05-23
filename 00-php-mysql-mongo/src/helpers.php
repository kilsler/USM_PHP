<?php
require_once __DIR__ . '/db.php';

/**
 * Сохраняет рецепт в файл.
 *
 * @param array $formData Ассоциативный массив с данными формы рецепта.
 * @return bool Возвращает true при успешной записи, иначе false.
 */
function saveRecipe($formData)
{
    $formData['tags'] = join(', ', $formData['tags']);
    $formData['steps'] = join('|', $formData['steps']);
    return createRecipe($formData);
}
/**
 * Обновляет рецепт в файле .
 *
 * @param array $formData Ассоциативный массив с данными формы рецепта.
 * @return bool Возвращает true при успешной записи, иначе false.
 */
function saveRecipeWithId($formData)
{
    $formData['tags'] = join(', ', $formData['tags']);
    $formData['steps'] = join('|', $formData['steps']);
    return updateRecipe($formData['id'], $formData);
}

/**
 * Рендерит темплэйт.
 *
 * @param string $templatePath Путь к файлу шаблона.
 * @param array $vars Ассоциативный массив с переменными для шаблона.
 * @return string Возвращает сгенерированный HTML-код.
 * @throws Exception Если файл шаблона не найден.
 */
function renderTemplate(string $templatePath, array $vars = []): string
{
    if (!file_exists($templatePath)) {
        return "<p>Шаблон $templatePath не найден.</p>";
    }

    extract($vars);
    ob_start();
    require $templatePath;
    return ob_get_clean();
}
/**
 * Рендер страницы.
 *
 * @param string $templateName Имя файла шаблона.
 * @param array $vars Ассоциативный массив с переменными для шаблона.
 * @return void
 */
function renderPage(string $templateName, array $vars = [])
{
    $content = renderTemplate(__DIR__ . "/../templates/{$templateName}.php", $vars);
    echo renderTemplate(__DIR__ . '/../templates/layout.php', ['content' => $content]);
}

/**
 * Очищает данные формы рецепта.
 *
 * @param array $formData Ассоциативный массив с необработанными данными формы.
 * @return array Обработанный и безопасный для использования массив данных.
 */
function filtrateForm($formData)
{
    $formData['title'] = htmlspecialchars($formData['title']);
    $formData['title'] = trim($formData['title']);
    $formData['category'] = htmlspecialchars($formData['category']);
    $formData['category'] = trim($formData['category']);
    $formData['ingredients'] = htmlspecialchars($formData['ingredients']);
    $formData['ingredients'] = trim($formData['ingredients']);
    $formData['description'] = htmlspecialchars($formData['description']);
    $formData['description'] = trim($formData['description']);
    $formData['tags'] = array_map('htmlspecialchars', $formData['tags']);
    $formData['tags'] = array_map('trim', $formData['tags']);
    $formData['steps'] = array_map('htmlspecialchars', $formData['steps']);
    $formData['steps'] = array_map('trim', $formData['steps']);

    return $formData;
}

/**
 * Проверяет валидность всех полей формы рецепта.
 *
 * @param array $formData Ассоциативный массив с данными формы.
 * @return bool Возвращает true, если все поля валидны, иначе false.
 */
function validateForm($formData)
{
    if (empty($formData)) {
        return false;
    }
    if (
        validateTitle($formData['title']) == false ||
        validateCategory($formData['category']) == false ||
        validateIngredients($formData['ingredients']) == false ||
        validateDescription($formData['description']) == false ||
        validateTags($formData['tags']) == false ||
        validateSteps($formData['steps']) == false
    ) {
        return false;
    }
    return true;
}
/**
 * Проверяет валидность заголовка рецепта.
 *
 * @param string $title Заголовок рецепта.
 * @return bool Возвращает true, если заголовок корректен, иначе false.
 */
function validateTitle($title)
{
    if (empty($title || strlen($title) < 3)) {
        return false;
    }
    return true;
}
/**
 * Проверяет валидность категории рецепта.
 *
 * @param string $category Категория рецепта.
 * @return bool Возвращает true, если категория указана, иначе false.
 */
function validateCategory($category)
{
    if (!isset($category) || empty($category)) {
        return false;
    }
    return true;
}
/**
 * Проверяет валидность списка ингредиентов.
 *
 * @param string $ingredients Строка с ингредиентами.
 * @return bool Возвращает true, если строка корректна, иначе false.
 */
function validateIngredients($ingredients)
{
    if (!isset($ingredients) || empty($ingredients) || strlen($ingredients) < 7) {
        return false;
    }
    return true;
}
/**
 * Проверяет валидность описания рецепта.
 *
 * @param string $description Описание рецепта.
 * @return bool Возвращает true, если описание корректно, иначе false.
 */
function validateDescription($description)
{
    if (!isset($description) || empty($description) || strlen($description) < 7) {
        return false;
    }
    return true;
}
/**
 * Проверяет валидность шагов приготовления.
 *
 * @param array $steps Массив шагов приготовления.
 * @return bool Возвращает true, если массив валиден, иначе false.
 */
function validateSteps($steps)
{
    if (!isset($steps) || !is_array($steps) || count($steps) < 1) {
        return false;
    }
    return true;
}
/**
 * Проверяет валидность тегов рецепта.
 *
 * @param array $tags Массив тегов.
 * @return bool Возвращает true, если теги указаны, иначе false.
 */
function validateTags($tags)
{
    if (!isset($tags) || empty($tags)) {
        return false;
    }
    return true;
}
