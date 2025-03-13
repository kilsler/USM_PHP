<?php 
define('PROJECT','Test');
require_once'./components/header.php';

$json_questions = file_get_contents('questions.json',true);
$questions = json_decode($json_questions,true)['questions'];
?>

<body >
    <div class="container w-60 mx-auto mt-5 p-4 border rounded">
    	<form action = "result.php" method = "POST" >
            <div class="mb-3">
                <label  class="h3 form-label">ВВедите своё имя</label>
                <input type="text" name='name' class="form-control" pattern="[A-Za-z ]+"  required>
            </div>
            <?php foreach ($questions as $index => $q): ?>
            <div class="card m-3 p-2">
            <div class="card-body">
                <label class="h3" ><?php echo $q['question'] ?></label>
                <?php foreach ($q['options'] as $option): ?>
                <div class="form-check">
                    <label class="form-check-label"><?php echo $option ?></label>
                    <input type = "<?php echo ($q['answer_type'] == 'one')?'radio':'checkbox';?>"
                            name = "question_<?php echo $index; ?><?php echo $q['answer_type'] == 'one' ? '' : '[]'; ?>"
                            class="form-check-input"
                            value="<?php echo $option; ?>"
                    ></input>
                </div>
                <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            <input class="btn btn-primary" type="submit">
        </form>
    </div>
</body>

<?php  require_once'./components/footer.php'; ?>