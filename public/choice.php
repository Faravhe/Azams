<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Azams — Choose</title>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@350&family=Inter:wght@400;500&family=IBM+Plex+Mono:wght@500&family=Noto+Sans+Bengali:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <p class="eyebrow">The choice</p>
  <h1>Pick one. </h1>
  <p>Whatever you choose, be prepare for anything.</p>

  <div class="choice-grid">
	<a class="choice-card" lang="bn" href="momin.php?choice=A">🍕 চোদ </a>
	<a class="choice-card" lang="bn" href="papi.php?choice=B">🚫 চোদনা</a>
  </div>

  <script src="../assets/js/cursor-follow.js"></script>
</body>
</html>
