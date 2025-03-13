<?php 
define('PROJECT','Test');
require_once'./components/header.php';
require_once'./functions.php';

if (isset($_POST)) {
    $questions = loadJsonData('questions.json')['questions'];
    $score = calculateUserScore($questions, $_POST);
    $final_score = updateResultsDashboard($_POST['name'], $score);
}

?>
<body >
    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis">
            Поздравляем <?php echo isset($_POST['name'])?$_POST['name']: 'Stranger';?>!
        </h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                Вы закончили тест на<b> <?php echo isset($final_score)?$final_score:0;  ?>%</b> , <b> <?php echo isset($score)?$score:0; ?></b> набранных балов!
            </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
    </div>
</body>
<?php  require_once'./components/footer.php'; ?>