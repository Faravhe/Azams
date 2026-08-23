<?php
function loadEnv($path) {
	if(!file_exists($path)) {
		die("Missing .env file at $path");
	}
	foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
		if (str_starts_with(trim($line), '#')) continue;
		[$key, $value] = explode('=', $line, 2);
		putenv(trim($key) . '=' . trim($value));
	}
}

loadEnv(__DIR__ . '/../.env');
