<?php

declare(strict_types = 1);

var_dump(DIRECTORY_SEPARATOR);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);


require APP_PATH . "App.php";

$files = getTransactionsFiles();

var_dump($files);