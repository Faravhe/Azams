<?php
require_once __DIR__ . '/lib/roast_lib.php';
$roast = generateRoastText();
header('Content-Type: application/json');
if (!$roast) {
    http_response_code(500);
    echo json_encode(['error' => 'Roast generation failed']);
} else {
    echo json_encode(['roast' => trim($roast)]);
}
