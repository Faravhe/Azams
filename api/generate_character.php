<?php
require_once __DIR__ . '/lib/character_lib.php';
$path = generateCharacterImage();
header('Content-Type: application/json');
if (!$path) {
	http_response_code(500);
	echo json_encode(['error' => 'Character generation failed']);
} else {
	echo json_encode(['success' => true, 'path' => $path]);
}
