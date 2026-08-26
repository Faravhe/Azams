<?php
function generateRoastText() {
    require_once __DIR__ . '/../../config/env.php';
    $apiKey = getenv('GEMINI_API_KEY');
    if (!$apiKey) return null;

    $prompt = "Write one short, playful, strong roast (max 2 sentences) for someone who just made a trivial choice between two silly options. Keep it silly and fun, never genuinely mean or targeting real sensitive traits.";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key=" . $apiKey;
    $payload = json_encode(['contents' => [['parts' => [['text' => $prompt]]]]]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) return null;

    $data = json_decode($response, true);
    return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
}
