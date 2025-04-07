<?php

function saveRecipe($formData){    
    $json = json_encode($formData, JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }
    echo __DIR__;
    return file_put_contents(__DIR__ . '/../storage/recipes.txt', $json . PHP_EOL, FILE_APPEND) !== false;
}


function filtrateForm($formData){
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


function validateForm( $formData ){
    if (empty($formData)) {
        return false;
    }
    if(
        validateTitle($formData['title']) == false ||
        validateCategory($formData['category']) == false ||
        validateIngredients($formData['ingredients']) == false ||
        validateDescription($formData['description']) == false ||
        validateTags($formData['tags']) == false ||
        validateSteps($formData['steps']) == false
    ){
        return false;
    }
    return true;
}

function validateTitle($title){
    if (empty($title || strlen($title) < 3)) {
        return false;
    }
    return true;
}
function validateCategory($category){
    if (!isset($category) || empty($category)) {
        return false;
    }
    return true;
}
function validateIngredients($ingredients){
    if ( !isset($ingredients) || empty($ingredients) || strlen($ingredients) < 7) {
        return false;
    }
    return true;
}
function validateDescription($description){
    if (!isset($description) || empty($description) || strlen($description) < 7) {
        return false;
    }
    return true;
}
function validateSteps($steps){
    if (!isset($steps) || !is_array($steps) || count( $steps) < 1) {
        return false;
    }
    return true;
}
function validateTags($tags){
    if (!isset($tags) || empty($tags)) {
        return false;
    }
    return true;
}