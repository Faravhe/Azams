<?php
require_once __DIR__ . '/../config/db.php';
$result = $conn->query("SELECT * FROM products ORDER BY id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Azams - Merch</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@350&family=Inter:wght@400;500&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <p class="eyebrow">Merch</p>
    <h1>Wear the roast.</h1>
    <p>Checkout isn't live yet — this is a preview of what's coming.</p>

    <div class="merch-grid">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="merch-card">
                <?php if ($product['image_path']): ?>
                    <img src="../<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php endif; ?>
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p class="merch-price">$<?= htmlspecialchars(number_format($product['price'], 2)) ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="roast-actions">
        <a class="landing-cta" href="index.php">Back home</a>
    </div>

    <script src="../assets/js/cursor-follow.js"></script>
    <script src="../assets/js/tilt-cards.js"></script>
</body>
</html>
