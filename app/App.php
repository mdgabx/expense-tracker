<?php

declare(strict_types = 1);

// code
function getTransactionsFiles(): array {
	$files = [];


	foreach(scandir(FILES_PATH) as $file) {
		if(is_dir($file)) {
			continue;
		}

		$files[] = $file;
	}

	return $files;
}