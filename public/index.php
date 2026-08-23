<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html>
<head><title>Azams</title></head>
<body>
<h1>Proceed at your own caution! 😁</h1>
<p>DB connected: <?= $conn->connect_error ? 'No' : 'Yes' ?></p>
</body>

</html>
