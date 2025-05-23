# Лабораторная работа №5 Morozan Nichita IA2303

## Инструкции по запуску проекта

Запуск проходит через терминал из папки с файлом index.php командой:  

` php -S localhost:8000 -t public`

## Описание лабораторной работы
Освоить архитектуру с единой точкой входа, подключение шаблонов для визуализации страниц, а также переход от хранения данных в файле к использованию базы данных (MySQL).

## Краткая документация к проекту
`/public/index.php`- главня страница с маршрутизацией;  
`/src/db.php`- функции бд(Все запросы осуществляются тут)  
`/src/helpers.php`- вспомогательные функции для формы.  
`/src/config/db.php`- конфиг бд(данные для подключения.  
`/src/handlers/index.php`- вспомогательный код для работы основной страницы.  
`/src/handlers/formHandler.php`- функции Обработки формы добавления и изменения.  
`/src/handlers/recipe/create.php`- вспомогательный код для страницы создания формы.  
`/src/handlers/recipe/delete.php`- вспомогельный код для страницы удаления.
`/src/handlers/recipe/edit.php`- вспомогательный код для страницы изменения рецепта.
`/src/handlers/recipe/index.php`- вспомогательный код для основной странцы со всеми рецептами.  
`/templates/layout.php`- Основной layot, на его основе строятся все осальные странцы. Содержит футер, хедер и блок для контента.  
`/templates/index.php`- страница для отображения списка всех рецептов.  
`/templates/error/php`- Страница для отображения ошибки.  
`/templates/recipe/create.php`- форма для создания нового рецепта.  
`/templates/recipe/delete.php`- страница с удалением рецепта.  
`/templates/recipe/edit.php`- страница с формой для изменения(в поля автоматически подставляются значения текущего рецепта).  
`/templates/recipe/index.php`- страница для отображения 1 рецепта с возможностью переключитьяс на изменения и удаление.

## Основные маршруты  
`/` или `./home` - главная страница со списком всех рецептов разбитых на странцы по 3 рецепта на каждой.  
`/recipe/create` - страница с добавлением нового рецепта  
`/recipe/:id` - страница определенного рецепта  
`/recipe/:id/edit` - страница с формой изменения рецепта  
`/recipe/:id/delete` - страница с удалением изменения рецепта  
`/error` - страница с ошибкой(при неправльном адрессе или несуществубщем рецепте)
## Примеры использования проекта 

![image](https://github.com/user-attachments/assets/9f39bedc-779e-42bf-a903-229488a684c3)  
![image](https://github.com/user-attachments/assets/8a940cbe-8ad5-4dc8-95be-f3d9887e03b1)
![image](https://github.com/user-attachments/assets/c9d5b0f7-d671-4942-b2fb-c315e41e856d)

## Ответы на котрольные вопросы  
1.Какие преимущества даёт использование единой точки входа в веб-приложении?  
Безопасность и удобство маршрутизации.  
2.Какие преимущества даёт использование шаблонов?  
Сокращение переиспользования кода, упрощение логики и структуры приложения.  
3.Какие преимущества даёт хранение данных в базе по сравнению с хранением в файлах?  
Многопользовательский доступ к данным, безопасность и управление доступом.  
4.Что такое SQL-инъекция? Придумайте пример SQL-инъекции и объясните, как её предотвратить. 
Это вставка sql кода в поле ввода с целью обхода логики и доступа к защищенным данным.  
  `SELECT * FROM users WHERE username = '' OR '1'='1'`


  
## Ответы на контрольные вопросы

