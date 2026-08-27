<?php
function generateCharacterImage() {
    $prompt = "A simple, friendly, hand-drawn cartoon character in the style of a folklore storyteller, warm colors, clean lines, expressive but simple face, front-facing, centered, plain neutral background, no text, no watermark";
    $encodedPrompt = urlencode($prompt);
    $seed = random_int(1, 999999);
    $url = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=512&height=512&nologo=true&model=flux&seed={$seed}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 75);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

    if ($httpCode !== 200 || !str_starts_with((string)$contentType, 'image/')) return null;

    $ext = str_contains($contentType, 'png') ? 'png' : 'jpg';
    $filename = 'character_' . time() . '.' . $ext;
    $filepath = __DIR__ . '/../../assets/generated/' . $filename;
    file_put_contents($filepath, $response);

    return 'assets/generated/' . $filename;
}
