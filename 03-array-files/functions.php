<?php
declare(strict_types=1);


$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
    [
        "id" => 3,
        "date" => "2021-06-10",
        "amount" => 200.00,
        "description" => "Online course subscription",
        "merchant" => "EduPlatform",
    ],
    [
        "id" => 4,
        "date" => "2022-09-05",
        "amount" => 150.75,
        "description" => "Electronics purchase",
        "merchant" => "TechStore",
    ],
    [
        "id" => 5,
        "date" => "2023-12-20",
        "amount" => 50.00,
        "description" => "Gift for friend",
        "merchant" => "GiftShop",
    ],
];


/**
 * Вычисление общей суммы всех транзакций.
 *
 * @param array $transactions Массив транзакций, где каждая транзакция — это ассоциативный массив с ключом "amount".
 * @return float Общая сумма всех транзакций.
 */
function calculateTotalAmount(array $transactions): float{
    $sum = 0.0;
    foreach ($transactions as $transaction) {
        $sum+=$transaction["amount"];
    }

    return $sum;
}

/**
 * Нахождение транзакций по фрагменту описания.
 *
 * @global array $transactions Глобальный массив транзакций
 * @param string $descriptionPart Строка являющаяся частью описания.
 * @return array Поля транзакции
 */
function findTransactionByDescription(string $descriptionPart){
    global $transactions;
    foreach ($transactions as $transaction) {
        if(str_contains(  strtolower($transaction["description"]) , strtolower( $descriptionPart))){
            return $transaction;
        }
    }

    return null;
}

/**
 * Нахождения транзакций по id
 *
 * @global array $transactions Глобальный массив транзакций
 * @param int $id ID искомой транзакции
 * @return array Транзакция в в иде массива полей.
 */
function findTransactionById(int $id){
    global $transactions;
    return array_filter($transactions,
        function(array $transaction) use ($id){
            return $transaction["id"] == $id;
    });
}

/**
 * Нахождения количество дней с момента транзакции
 *
 * @global array $transactions Глобальный массив транзакций
 * @param string $date Дата в формате строки(Y-m-d)
 * @return int Количество дней с момента транзакции
 */
function daysSinceTransaction(string $date): int{
    global $transactions;
    $currentDate = time();
    $transactionDate = strtotime($date);
    return intval(round(($currentDate-$transactionDate )/(60*60*24)));
}

/**
 * Добавление транзакции
 *
 * @global array $transactions Глобальный массив транзакций
 * @param int $id Айди транзакции
 * @param string $date Дата в формате (Y-m-d)
 * @param float $amount Сумма транзакции
 * @param string $description Описание транзакции
 * @param string $merchant Продавец
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void{
    global $transactions;
    $transactions[] = [ 
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}

/**
 * Сортировка массива транзакций по дате(по возрастанию)
 *
 * @global array $transactions Глобальный массив транзакций
 * @return array Отсортированый массив
 */
function sortByDate(): array{
    global $transactions;
    usort($transactions,function(array $t1,array $t2){
        if($t1 == $t2 ) 
            return 0;
        return (strtotime($t1["date"]) < strtotime($t2["date"])) ? -1 : 1;
    });

    return $transactions;
}

/**
 * Сортировка массива транзакций сумме транзакции
 *
 * @global array $transactions Глобальный массив транзакций
 * @return array Отсортированый массив
 */
function sortDesc(): array{
    global $transactions;
    usort($transactions,function(array $t1,array $t2){
        if($t1 == $t2 ) 
            return 0;
        return ($t1["amount"] < $t2["amount"]) ? 1 : -1;
    });

    return $transactions;
}