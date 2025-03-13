# Альтернативная аттестационная работа N1 Morozan Nichita IA2303

## Инструкции по запуску проекта

Запуск проходит через терминал из папки с файлом index.php командой:  

` php -S localhost:8000`  
Для правльной работы стилей необходимо подключение к интернету.  

## Краткое описание функционала приложения
  Приложение для прохождение тестов. Данные для вопросов берутся из json файла. Результаты тестирования сохраняются в json файл. В приложении присутствует валидация данных.

## Краткая документация к проекту
  */components/footer.php* - футер проекта  
  */components/header.php* - хэдер проекта  
  */functions.php* - функции подсчета оценки и сохранения данных в json  
  *result.php* - результат теста  
  *dashboard.php* - все результаты теста  
  *index.php* -главная страница и страница выполнения теста  
  *results_dashboard.json* - все записаные результаты  
  *questions.json* - массив вопросов  
  
## Структура базы данных или файла
*results_dashboard.json*  
`  
[  
{  
  'name': 'Пример имени',  
  'score':'Пример оценка тестируемого'  
}  
]  
`  
*questions.json*  
`  
{"questions":
[  
{  
  "question": "Какой язык программирования считается основным для разработки Android-приложений?",
  "options": ["Python", "Kotlin", "Swift", "C#"],
  "answer_type": "one",
  "correct_answer": "Kotlin"
}  
]  
}
`  
## Примеры тестов.
![image](https://github.com/user-attachments/assets/3c4a413d-45e3-4578-866a-a046a27670ba)  

![image](https://github.com/user-attachments/assets/b85f0caa-8f09-477a-bf33-48b19f69b366)  

## Скриншоты работы приложения.

  ![image](https://github.com/user-attachments/assets/2c3c1536-2b51-434d-8c61-dbed3962a173)  
  ![image](https://github.com/user-attachments/assets/14e6b9ef-bc07-4ea4-bc28-3a790a944391)

