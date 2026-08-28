<?php
set_time_limit(90);
ini_set('max_execution_time', 90);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../api/lib/roast_lib.php';
require_once __DIR__ . '/../api/lib/character_lib.php';

if (!isset($_COOKIE['session_name'])) {
    $sessionName = 'guest_' . substr(md5(uniqid()), 0, 8);
    setcookie('session_name', $sessionName, time() + (86400 * 30), '/');
} else {
    $sessionName = $_COOKIE['session_name'];
}

$roastText = generateRoastText() ?? "Even the AI is speechless. That's honestly worse than any roast.";
$characterPath = generateCharacterImage();

$stmt = $conn->prepare("INSERT INTO roast_history (session_name, choice_made, roast_text) VALUES (?, 'PAPI', ?)");
$stmt->bind_param("ss", $sessionName, $roastText);
$stmt->execute();

$progStmt = $conn->prepare("SELECT story_id, current_part FROM user_story_progress WHERE session_name = ? AND completed = 0 ORDER BY updated_at ASC LIMIT 1");
$progStmt->bind_param("s", $sessionName);
$progStmt->execute();
$progress = $progStmt->get_result()->fetch_assoc();

if ($progress) {
    $storyId = $progress['story_id'];
    $nextPart = $progress['current_part'] + 1;
} else {
    $pickStmt = $conn->prepare("SELECT id FROM folklore_stories WHERE id NOT IN (SELECT story_id FROM user_story_progress WHERE session_name = ? AND completed = 1) ORDER BY id LIMIT 1");
    $pickStmt->bind_param("s", $sessionName);
    $pickStmt->execute();
    $row = $pickStmt->get_result()->fetch_assoc();
    $storyId = $row ? $row['id'] : 1;
    $nextPart = 1;
}

$storyStmt = $conn->prepare("SELECT title, culture, total_parts, moral FROM folklore_stories WHERE id = ?");
$storyStmt->bind_param("i", $storyId);
$storyStmt->execute();
$story = $storyStmt->get_result()->fetch_assoc();

$partStmt = $conn->prepare("SELECT content FROM folklore_parts WHERE story_id = ? AND part_number = ?");
$partStmt->bind_param("ii", $storyId, $nextPart);
$partStmt->execute();
$part = $partStmt->get_result()->fetch_assoc();

$isLastPart = ($nextPart >= $story['total_parts']);
$completedFlag = $isLastPart ? 1 : 0;

$upsertStmt = $conn->prepare("INSERT INTO user_story_progress (session_name, story_id, current_part, completed) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE current_part = VALUES(current_part), completed = VALUES(completed), updated_at = CURRENT_TIMESTAMP");
$upsertStmt->bind_param("siii", $sessionName, $storyId, $nextPart, $completedFlag);
$upsertStmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Azams - Papi</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@350&family=Inter:wght@400;500&family=IBM+Plex+Mono:wght@500&family=Noto+Sans+Bengali:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <p class="eyebrow" lang="bn">PAPI</p>
    <h1>Papi Papi Papi Chulo!</h1>

    <div class="roast-scene">
        <?php if ($characterPath): ?>
            <img class="character-portrait" src="../<?= htmlspecialchars($characterPath) ?>" alt="Your roast">
        <?php endif; ?>

        <div class="speech-bubble">
            <?= htmlspecialchars($roastText) ?>
            <svg class="tail" width="24" height="20" viewBox="0 0 24 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 0 L0 10 L24 20 Z" fill="#F2EDE4"/>
            </svg>
        </div>
    </div>

    <div class="story-panel">
        <p class="eyebrow"><?= htmlspecialchars($story['title']) ?> &middot; <?= htmlspecialchars($story['culture']) ?> &middot; Part <?= $nextPart ?> of <?= $story['total_parts'] ?></p>
        <p><?= htmlspecialchars($part['content']) ?></p>
        <?php if ($isLastPart): ?>
            <p><strong>Moral:</strong> <?= htmlspecialchars($story['moral']) ?></p>
        <?php else: ?>
            <p><em>Come back and choose again to continue this tale.</em></p>
        <?php endif; ?>
    </div>

    <div class="roast-actions">
        <a class="landing-cta" href="choice.php">Choose Again</a>
    </div>

    <script src="../assets/js/cursor-follow.js"></script>
    <script src="../assets/js/loading-overlay.js"></script>
</body>
</html>
