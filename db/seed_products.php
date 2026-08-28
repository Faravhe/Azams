<?php
require_once __DIR__ . '/../config/db.php';

function generateProductImage($prompt, $filenamePrefix) {
    $encodedPrompt = urlencode($prompt);
    $seed = random_int(1, 999999);
    $url = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=512&height=512&nologo=true&model=flux&seed={$seed}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

    if ($httpCode != 200 || !str_starts_with((string)$contentType, 'image/')) {
        return null;
    }

    $ext = str_contains($contentType, 'png') ? 'png' : 'jpg';
    $filename = $filenamePrefix . '_' . time() . '.' . $ext;
    $filepath = __DIR__ . '/../assets/generated/' . $filename;
    file_put_contents($filepath, $response);

    return 'assets/generated/' . $filename;
}

$loremShort = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";

$products = [
    ['name' => 'Azams Poster', 'category' => 'poster', 'price' => 15.00, 'prompt' => 'a colorful minimalist poster design mockup on a wall, product photography style'],
    ['name' => 'Azams T-Shirt', 'category' => 'shirt', 'price' => 22.00, 'prompt' => 'a plain t-shirt with a graphic print, flat lay product photography style'],
    ['name' => 'Azams Sticker Pack', 'category' => 'sticker', 'price' => 6.00, 'prompt' => 'a small sheet of colorful vinyl stickers, product photography style'],
];

$stmt = $conn->prepare("INSERT INTO products (name, category, description, price, image_path) VALUES (?, ?, ?, ?, ?)");

foreach ($products as $p) {
    $imagePath = generateProductImage($p['prompt'], $p['category']);
    $stmt->bind_param("sssds", $p['name'], $p['category'], $loremShort, $p['price'], $imagePath);
    $stmt->execute();
    echo "Seeded: {$p['name']} (" . ($imagePath ?? 'image failed') . ")\n";
}

echo "Done.\n";
