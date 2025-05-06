# Индивидуальная работа по предмету PHP
# Morozan Nichita IA2303
## Тема : Веб-приложение по хранению и обработке рецептов
## Инструкции по запуску проекта

Запуск проходит через терминал из папки `/public` с файлом index.php командой:  

` php -S localhost:8000 -t public`

## Описание лабораторной работы
Разработайте веб-приложение средней сложности, содержащее функционал, реализованный на стороне сервера. 
Реализовать веб-приложение с хранением рецептов в бд Mysql и хранением комментариев в MongoDB.  
PHP часть использует PDO для подключения к mysql с использованием prepared statement для обеспечения защиты от sql-инъекций.  
MongoCommentariesRecipesApplication - JAVA SPRING API для работы с MongoDB. Использует уже существющий репозиторий MongoRepository для обращения к бд.
Валидация рецептов осуществена на сторое PHP, валидация комментариев осущественна на стороне html-формы и на стороне валидации в mongodb.

## Структура баз данных
### Mysql:
![image](https://github.com/user-attachments/assets/678275fe-dbfd-4a78-ada3-15fd99f608d7)  
  ```sql
  CREATE TABLE recipes (  
   id INT AUTO_INCREMENT PRIMARY KEY,  
   title VARCHAR(255) NOT NULL,  
   category INT NOT NULL,  
   ingredients TEXT,  
   description TEXT,  
   tags TEXT,  
   steps TEXT,  
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
   FOREIGN KEY (category) REFERENCES categories(id) ON  
DELETE  
	CASCADE  
);  
  
CREATE TABLE categories (  
   id INT AUTO_INCREMENT PRIMARY KEY,  
   name VARCHAR(100) NOT NULL UNIQUE,  
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);  
```
### MongoDB:
Структура через валидацию в MongoDB  
```  
{
  $jsonSchema: {  
    bsonType: 'object',  
    required: [  
      'recipe_id',  
      'name',  
      'email',  
      'content',  
      'date',  
      'score'  
    ],  
    properties: {  
      _id: {  
        bsonType: 'objectId'  
      },  
      recipe_id: {  
        bsonType: 'string'  
      },  
      name: {  
        bsonType: 'string'  
      },  
      email: {  
        bsonType: 'string'  
      },  
      content: {  
        bsonType: 'string'  
      },  
      attachments: {  
        bsonType: 'array',  
        items: {  
          bsonType: 'string'  
        }  
      },  
      date: {  
        bsonType: 'date'  
      },  
      score: {  
        bsonType: 'int',  
        minimum: 1,  
        maximum: 10  
      }  
    }  
  }  
}  
```

## Краткая документация к проекту
### PHP приложение с подключением к Mysql :  
`/public/index.php`- главня страница с маршрутизацией;  
`/src/db.php`- функции бд(Все запросы осуществляются тут)  
`/src/helpers.php`- вспомогательные функции для формы.  
`/src/config/db.php`- конфиг бд(данные для подключения.  
`/src/config/auth.php`- Небходимые функции для аутентификации.  
`/src/handlers/index.php`- вспомогательный код для работы основной страницы.  
`/src/handlers/formHandler.php`- функции Обработки формы добавления и изменения.  
`/src/handlers/recipe/create.php`- вспомогательный код для страницы создания формы.  
`/src/handlers/recipe/delete.php`- вспомогельный код для страницы удаления.
`/src/handlers/recipe/edit.php`- вспомогательный код для страницы изменения рецепта.
`/src/handlers/recipe/index.php`- вспомогательный код для основной странцы со всеми рецептами.  
`/templates/layout.php`- Основной layot, на его основе строятся все осальные странцы. Содержит футер, хедер и блок для контента.  
`/templates/index.php`- страница для отображения списка всех рецептов.  
`/templates/error/php`- Страница для отображения ошибки.  
`/templates/auth/login.php`- Страница логин формы.  
`/templates/recipe/create.php`- форма для создания нового рецепта.  
`/templates/recipe/delete.php`- страница с удалением рецепта.  
`/templates/recipe/edit.php`- страница с формой для изменения(в поля автоматически подставляются значения текущего рецепта).  
`/templates/recipe/index.php`- страница для отображения 1 рецепта с возможностью переключитьяс на изменения и удаление.  
### Spring Api с подключением к mongodb:
`/controller/CommentController.java` - контроллер для обработки запросов на API.  
`/entity/Comment.java` -  Entity структура используемой коллекции.  
`/repository/CommentRepository.java` - репозиторий, расширяет MongoRepository для удобной работы с MongoDB.  

## SPRING API Controller  
```java
package com.moro274.mongo_commentaries_recipes.controller;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.moro274.mongo_commentaries_recipes.entity.Comment;
import com.moro274.mongo_commentaries_recipes.repository.CommentRepository;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.Date;
import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/comments")
@CrossOrigin
public class CommentController {

    private final CommentRepository repository;

    public CommentController(CommentRepository repository) {
        this.repository = repository;
    }

    @GetMapping("/{recipeId}")
    public List<Comment> getCommentsByRecipe(@PathVariable String recipeId) {
        return repository.findByRecipeId(
                recipeId);
    }

    @PostMapping("/{recipeId}")
    public ResponseEntity<?> addComment(@PathVariable String recipeId, @RequestBody Comment comment) {
        comment.setDate(new Date());
        comment.setRecipeId(recipeId);
        repository.save(comment);
        return ResponseEntity.ok(Map.of("success", true));
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateComment(@PathVariable String id, @RequestBody Comment newData) {
        return repository.findById(id)
                .map(existing -> {
                    existing.setName(newData.getName());
                    existing.setEmail(newData.getEmail());
                    existing.setContent(newData.getContent());
                    existing.setScore(newData.getScore());
                    existing.setAttachments(newData.getAttachments());
                    repository.save(existing);
                    return ResponseEntity.ok(Map.of("success", true));
                })
                .orElse(ResponseEntity.notFound().build());
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteComment(@PathVariable String id) {
        if (repository.existsById(id)) {
            repository.deleteById(id);
            return ResponseEntity.ok(Map.of("success", true));
        }
        return ResponseEntity.notFound().build();
    }

    @GetMapping("/{recipeId}/score")
    public ResponseEntity<?> getAverageScore(@PathVariable String recipeId) {
        List<Comment> comments = repository.findByRecipeIdOrderByDateDesc(recipeId);
        double average = comments.stream()
                .filter(c -> c.getScore() != null)
                .mapToInt(Comment::getScore)
                .average()
                .orElse(0.0);
        return ResponseEntity.ok(Map.of(
                "recipeId", recipeId,
                "averageScore", average
        ));
    }
}


```

## PHP MySql контроллер
```php
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

```
## Основные маршруты  
`/` или `./home` - главная страница со списком всех рецептов разбитых на странцы по 3 рецепта на каждой.  
`/login` - вход в аккаунт  
`/logout` - выход из аккаунта   
`/recipe/create` - страница с добавлением нового рецепта  
`/recipe/:id` - страница определенного рецепта  
`/recipe/:id/edit` - страница с формой изменения рецепта  
`/recipe/:id/delete` - страница с удалением изменения рецепта  
`/error` - страница с ошибкой(при неправльном адрессе или несуществубщем рецепте)  
## Примеры использования проекта 
![image](https://github.com/user-attachments/assets/f6e1694a-52ea-41f3-b27f-22061119f641)  
рис(1) главная страница  
![image](https://github.com/user-attachments/assets/ceef8332-7997-4ba7-bb24-93747825515e)  
рис(2) Страница с рецептом  
![image](https://github.com/user-attachments/assets/f98cd37f-c4db-4c11-b31a-a91cbecf642b)  
рис(3) Изменение комментария и вид для зарегистрированного пользователя  
![image](https://github.com/user-attachments/assets/a01ac81b-8820-4ee2-8203-97cf360565c1)  
рис(4) Просмотри незарегистрированным пользователем  



