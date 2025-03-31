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

function getTransactions(string $fileName): array {
    if (!file_exists($fileName)) {
        trigger_error('File "' . $fileName . '" does not exist.', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');

    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) { // FIXED CONDITION
        $transactions[] = $transaction;
    }

    fclose($file); // Close the file after reading

    return $transactions;
}
