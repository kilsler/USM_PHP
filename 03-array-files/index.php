<?php 
declare(strict_types=1);
define('PROJECT','Test');
require_once'./components/header.php';
require_once'./functions.php';


//echo calculateTotalAmount($transactions);
//echo print_r(findTransactionByDescription($transactions,"Dinner"))
//echo print_r(findTransactionById($transactions,1))
//echo daysSinceTransaction($transactions[0]["date"]);
//print_r(sortByDate());
//print_r(sortDesc());
?>

<div class="container w-60 mx-auto mt-5 p-4 border rounded">
    <table class="table">
        <thead class="table-info">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
                <th scope="col">Description</th>
                <th scope="col">Merchant</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($transactions as $key=>$transaction): ?>
                <tr>
                    <td><?= $transaction["id"]; ?></td>
                    <td><?= $transaction["date"]; ?></td>
                    <td><?= $transaction["amount"]; ?></td>
                    <td><?= $transaction["description"]; ?></td>
                    <td><?= $transaction["merchant"]; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th>Total Summ</th>
                <td class="text-center" colspan = "4"><?= calculateTotalAmount($transactions); ?></td>
            </tr>
        </tbody>
    </table>
</div>


<?php  require_once'./components/footer.php'; ?>