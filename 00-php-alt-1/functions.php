<?php

/**
 * Загружает данные из JSON-файла.
 *
 * @param string $filename Имя файла JSON.
 * @return array Декодированные данные JSON.
 */
function loadJsonData($filename) {
    $jsonData = file_get_contents($filename);
    return json_decode($jsonData, true);
}

/**
 * Вычисляет максимальное количество баллов за тест.
 *
 * @param array $questions Массив вопросов.
 * @return float Максимальное количество баллов.
 */
function calculateMaxScore($questions) {
    $max_score = 0;
    foreach ($questions as $question) {
        if ($question['answer_type'] == 'one') {
            $max_score += 1;
        } else {
            $max_score += count($question['correct_answer']) * 0.5;
        }
    }
    return $max_score;
}

/**
 * Вычисляет количество баллов, набранных пользователем.
 *
 * @param array $questions Массив вопросов.
 * @param array $postData Данные, полученные через POST-запрос.
 * @return float Количество баллов, набранных пользователем.
 */
function calculateUserScore($questions, $postData) {
    $score = 0;
    foreach ($questions as $index => $question) {
        $user_answer = isset($postData['question_' . $index]) ? $postData['question_' . $index] : [];
        $correct_answer = $question['correct_answer'];
        if ($question['answer_type'] == 'one') {
            if ($user_answer == $correct_answer) {
                $score += 1;
            }
        } else {
            $user_answers = is_array($user_answer) ? $user_answer : [$user_answer];
            foreach ($user_answers as $answer) {
                if (in_array($answer, $correct_answer)) {
                    $score += 0.5;
                } else {
                    $score -= 0.5;
                }
            }
        }
    }
    return $score;
}

/**
 * Обновляет результаты на дашборде и возвращает проценты выполненой работы.
 *
 * @param string $name Имя пользователя.
 * @param float $score Набранные баллы.
 * @return float Финальный процентный балл.
 */
function updateResultsDashboard($name, $score) {
    $dashboard_data = loadJsonData('results_dashboard.json');
    $max_score = calculateMaxScore(loadJsonData('questions.json')['questions']);
    $final_score = round(($score / $max_score) * 100, 2);
    $new_result = ["name" => $name, "score" => $final_score];
    $dashboard_data[] = $new_result;
    file_put_contents('results_dashboard.json', json_encode($dashboard_data));
    return $final_score;
}
