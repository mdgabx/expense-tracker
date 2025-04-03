<?php

declare(strict_types = 1);

function getTransactionsFiles(string $dirPath): array {
    $files = [];

    foreach (scandir($dirPath) as $file) {
        if ($file === '.' || $file === '..' || is_dir($dirPath . DIRECTORY_SEPARATOR . $file)) {
            continue;
        }

        $files[] = $dirPath . DIRECTORY_SEPARATOR . $file;
    }

    return $files;
}

function getTransactions(string $fileName, ?callable $transactionHandler = null): array {
    if (!file_exists($fileName)) {
        trigger_error('File "' . $fileName . '" does not exist.', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');

    fgetcsv($file); // discard the heaaders

    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) {

        // make it flexible if csv has other formats aside the given ones
        if ($transactionHandler !== null) {
            $transaction = $transactionHandler($transaction);   
        }

        $transactions[] = $transaction;
    }

    // fclose($file); // Close the file after reading

    return $transactions;
}

function parseTransactions(array $transactionRow): array {

    // var_dump($transactionRow);

    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $amount = (float) str_replace(['$', ','], '', $amount);

    return [
        'date'        => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount'      => $amount
    ];
}

function calculateTotals(array $transactions): array {

    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];


    foreach($transactions as $transaction) {
        $totals['netTotal'] += $transaction['amount'];

        if ($transaction['amount'] > 0) {
            $totals['totalIncome'] += $transaction['amount'];
        } else {
            $totals['totalExpense'] += $transaction['amount'];
        }
    }

    return $totals;

}