<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Azams</title>
	<link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@350&family=Inter:wght@400;500&family=IBM+plex+Mono:wght@500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
	<p class="eyebrow">Go back if you concerned about your mental health!</p>
	<h1>You are in Azams tetitory <span>&#x1F3F0;</span> Proceed at your own caution! 😁</h1>
	<p>DB connected: <?= $conn->connect_error ? 'No' : 'Yes' ?></p>
	<a class="landing-cta" href="choice.php">Enter if you dare</a>

	<script src="../assets/js/cursor-follow.js"></script>
	<script src="../assets/js/loading-overlay.js"></script>
</body>

</html>
