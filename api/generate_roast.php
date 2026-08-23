<?php
require_once __DIR__ . '/../config/env.php';

$apiKey = getenv('GEMINI_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    die(json_encode(['error' => 'Missing GEMINI_API_KEY']));
}

$prompt = "Write one short, playful, brutal roast (max 2 sentences) for someone who just made a trivial choice between two silly options. Keep it silly and fun, maybe somehow  mean but try to avoid targeting real sensitive traits.";

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key=" . $apiKey;

$payload = json_encode([
    'contents' => [
        ['parts' => [['text' => $prompt]]]
    ]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    die(json_encode(['error' => 'Gemini API error', 'details' => $response]));
}

$data = json_decode($response, true);
$roastText = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Roast generation failed - but honestly, that is roast-worthy too.';

header('Content-Type: application/json');
echo json_encode(['roast' => trim($roastText)]);
