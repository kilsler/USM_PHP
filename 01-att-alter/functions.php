<?php

function loadJsonData($filename) {
    $jsonData = file_get_contents($filename);
    return json_decode($jsonData, true);
}


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


function updateResultsDashboard($name, $score) {
    $dashboard_data = loadJsonData('results_dashboard.json');
    $max_score = calculateMaxScore(loadJsonData('questions.json')['questions']);
    $final_score = round(($score / $max_score) * 100, 2);
    $new_result = ["name" => $name, "score" => $final_score];
    $dashboard_data[] = $new_result;
    file_put_contents('results_dashboard.json', json_encode($dashboard_data));
    return $final_score;
}
