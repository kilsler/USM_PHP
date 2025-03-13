<?php 
define('PROJECT','Blog');
require_once'./components/header.php';


$dashboard= file_get_contents('results_dashboard.json',true);
$results  = json_decode($dashboard,true);
?>

<div class="container w-60 mx-auto mt-5 p-4 border rounded">
   <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Score</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $index => $row): ?>
          <tr>
            <th scope="row"><?php echo $index ?></th>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['score'] ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php  require_once'./components/footer.php'; ?>