<?php
set_time_limit(90);
ini_set('max_execution_time', 90);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../api/lib/roast_lib.php';
require_once __DIR__ . '/../api/lib/character_lib.php';

$choice = $_GET['choice'] ?? 'unknown';
$choiceLabel = $choice === 'A' ? 'চোদ' : ($choice === 'B' ? 'চোদনা' : 'unknown');
if (!isset($_COOKIE['session_name'])) {
	$sessionName = 'guest_' . substr(md5(uniqid()), 0, 8);
	setcookie('session_name', $sessionName, time() + (86400 * 30), '/');
} else {
	$sessionName = $_COOKIE['session_name'];
}

$roastText = generateRoastText() ?? "Even the AI is speechless, That's honestly worse than any roast.";
$characterPath = generateCharacterImage();

$stmt = $conn->prepare("INSERT INTO roast_history (session_name, choice_made, roast_text) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $sessionName, $choiceLabel, $roastText);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Azams - Roasted</title>
	<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@350&family=Inter:wght@400;500&family=IBM+Plex+Mono:wght@500&family=Noto+Sans+Bengali:wght@400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
	<p class="eyebrow" lang="bn">You chose: <?= htmlspecialchars($choiceLabel) ?></p>
	<h1>Buckle your seatbelt, you are about to fly!</h1>

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

	<div class="roast-actions">
		<a class="landing-cta" href="choice.php">Choose again</a>
	</div>

	<script src="../assets/js/cursor-follow.js"></script>
	<script src="../assets/js/loading-overlay.js"></script>
</body>
</html>
