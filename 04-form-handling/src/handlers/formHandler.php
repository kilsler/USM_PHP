<?php
require_once __DIR__ . '/../helpers.php';

/**
 * Обрабатывает данные формы рецепта.
 *
 * @return void ничего 
 */
function handleForm(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (validateForm($_POST)) {
            $formData = [
                'title' => $_POST['title'],
                'category' => $_POST['category'],
                'ingredients' => $_POST['ingredients'],
                'description' => $_POST['description'],
                'tags' => $_POST['tags'],
                'steps' => $_POST['steps']
            ];
            $formData = filtrateForm($formData);
            saveRecipe($formData);
            echo "<div class='alert alert-success'>Рецепт {$formData['title']} успешно добавлен!</div>";
        } else {
            echo "<div class='alert alert-danger'>Ошибка! Проверьте правильность заполнения формы.</div>";
        }
    }
}