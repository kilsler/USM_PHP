<?php 
define('PROJECT','Blog');
require_once'./components/header.php';

$jsonQuestions = file_get_contents('questions.json',true);
$questions = json_decode($jsonQuestions,true)['questions'];
$dashboard = file_get_contents('results_dashboard.json',true);
$dashboard_data = json_decode($dashboard,true);
$max_score = 0;
foreach($questions as $index => $question){
    if ($question['answer_type'] == 'one') {
        $max_score += 1;
    }else{
        $max_score+= count($question['correct_answer']) * 0.5;
    }
}

if(isset($_POST)){
    $score = 0;
    foreach ($questions as $index => $question) { 
        $user_answer = isset($_POST['question_' . $index]) ? $_POST['question_' . $index] : [];
        $correct_answer = $question['correct_answer'];
        if ($question['answer_type'] == 'one') {
            if ($user_answer == $correct_answer) {
                $score += 1;
            }
        }else{
            $user_answers = is_array($user_answer) ? $user_answer : [$user_answer];
            foreach ($user_answers as $answer) {
                if( is_array($answer)){
                    print_r($answer);
                }
                if (in_array($answer, $correct_answer)) {
                    $score += 0.5;
                } else {
                    $score -=0.5;
                }
            }
        }
    }
}   
$final_score = round(($score / $max_score) * 100,2);
$new_result = ["name" => $_POST['name'],
    "score" => $final_score];
$dashboard_data[] = $new_result;
$dashboard = json_encode($dashboard_data);
file_put_contents('results_dashboard.json', $dashboard);
?>
<body >
    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis">
            Поздравляем <?php echo $_POST['name']?>!
        </h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                Вы закончили тест на<b> <?php echo $final_score; ?>%</b> , <b> <?php echo $score; ?></b> набранных балов!
            </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
    </div>
</body>
<?php  require_once'./components/footer.php'; ?>