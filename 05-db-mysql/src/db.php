<?php

function getConnection()
{
    $config = require __DIR__ . '/config/db.php';
    $servername = $config['servername'];
    $username = $config['username'];
    $password = $config['password'];
    $dbname = $config['dbname'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

function getAllRecipes()
{
    $conn = getConnection();
    if ($conn) {
        $sql = "SELECT 
                recipes.id,
                recipes.title,
                recipes.category,
                recipes.ingredients,
                recipes.description,
                recipes.tags,
                recipes.steps,
                recipes.created_at,
                categories.name 
         FROM recipes INNER JOIN categories 
         ON recipes.category = categories.id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return null;
}

function getAllCategories()
{
    $conn = getConnection();
    if ($conn) {
        $sql = "SELECT * FROM categories";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return null;
}

function getRecipeById($id)
{
    $conn = getConnection();
    if ($conn) {
        $sql = "SELECT 
                recipes.id,
                recipes.title,
                recipes.category,
                recipes.ingredients,
                recipes.description,
                recipes.tags,
                recipes.steps,
                recipes.created_at,
                categories.name 
         FROM recipes 
                INNER JOIN categories ON recipes.category = categories.id 
                WHERE recipes.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}


function deleteRecipe($id)
{
    $conn = getConnection();
    if ($conn) {
        $sql = "DELETE FROM recipes WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    return false;
}

function createRecipe($recipe)
{
    $conn = getConnection();
    if ($conn) {
        $sql = "INSERT INTO recipes (title, category, ingredients,description,tags,steps) VALUES (:title, :category, :ingredients,:description,:tags,:steps)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $recipe['title']);
        $stmt->bindParam(':category', $recipe['category']);
        $stmt->bindParam(':ingredients', $recipe['ingredients']);
        $stmt->bindParam(':description', $recipe['description']);
        $stmt->bindParam(':tags', $recipe['tags']);
        $stmt->bindParam(':steps', $recipe['steps']);
        return $stmt->execute();
    }
    return false;
}

function updateRecipe($id, $recipe)
{
    $conn = getConnection();
    if ($conn) {
        $sql = "UPDATE recipes SET title = :title, category = :category, ingredients = :ingredients, description = :description, tags = :tags, steps = :steps WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $recipe['title']);
        $stmt->bindParam(':category', $recipe['category']);
        $stmt->bindParam(':ingredients', $recipe['ingredients']);
        $stmt->bindParam(':description', $recipe['description']);
        $stmt->bindParam(':tags', $recipe['tags']);
        $stmt->bindParam(':steps', $recipe['steps']);
        return $stmt->execute();
    }
    return false;
}
