<?php
require_once __DIR__ . '/../config/db.php';

if (!isset($_COOKIE['session_name'])) {
    $sessionName = 'guest_' . substr(md5(uniqid()), 0, 8);
    setcookie('session_name', $sessionName, time() + (86400 * 30), '/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Azams - Momin</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@350&family=Inter:wght@400;500&family=IBM+Plex+Mono:wght@500&family=Noto+Sans+Bengali:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <p class="eyebrow" lang="bn">MOMIN</p>
    <h1>The illusion quest is still being built.</h1>
    <p>This is where your brain gets trained to see differently. Coming soon.</p>

    <div class="roast-actions">
        <a class="landing-cta" href="choice.php">Back to the choice</a>
    </div>

    <script src="../assets/js/cursor-follow.js"></script>
</body>
</html>
