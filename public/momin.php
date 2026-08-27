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
    <h1>Three quests. Look closely — your brain is about to lie to you.</h1>
    <p>Optical illusions aren't magic, they're your brain taking shortcuts. Look at each one before reading the explanation.</p>

    <div class="quest-panel">
        <p><strong>Quest 1 — The Café Wall</strong></p>
        <div>
            <div class="cafe-wall-row">
                <div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div>
            </div>
            <div class="cafe-wall-row offset">
                <div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div>
            </div>
            <div class="cafe-wall-row">
                <div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div><div class="cafe-wall-tile dark"></div><div class="cafe-wall-tile light"></div>
            </div>
        </div>
        <details>
            <summary>What's actually happening?</summary>
            <p>Every row is perfectly straight and horizontal. The thin gray borders between light and dark tiles trick your brain's edge-detection into reading them as tilted, because of how the offset squares change the contrast at each border.</p>
        </details>
    </div>

    <div class="quest-panel">
        <p><strong>Quest 2 — The Same-Size Circles</strong></p>
        <div class="ebbinghaus-group">
            <div class="ebbinghaus-cluster">
                <div class="ebbinghaus-satellite" style="width:70px; height:70px; top:-10px; left:-10px;"></div>
                <div class="ebbinghaus-satellite" style="width:70px; height:70px; top:-10px; right:-10px;"></div>
                <div class="ebbinghaus-satellite" style="width:70px; height:70px; bottom:-10px; left:-10px;"></div>
                <div class="ebbinghaus-satellite" style="width:70px; height:70px; bottom:-10px; right:-10px;"></div>
                <div class="ebbinghaus-center"></div>
            </div>
            <div class="ebbinghaus-cluster">
                <div class="ebbinghaus-satellite" style="width:18px; height:18px; top:0; left:20px;"></div>
                <div class="ebbinghaus-satellite" style="width:18px; height:18px; top:0; right:20px;"></div>
                <div class="ebbinghaus-satellite" style="width:18px; height:18px; bottom:0; left:20px;"></div>
                <div class="ebbinghaus-satellite" style="width:18px; height:18px; bottom:0; right:20px;"></div>
                <div class="ebbinghaus-center"></div>
            </div>
        </div>
        <details>
            <summary>What's actually happening?</summary>
            <p>Both orange circles are exactly the same size. Your brain judges size by comparison to what's nearby, so surrounding one with big circles makes it look smaller, and surrounding the other with small circles makes it look bigger.</p>
        </details>
    </div>

    <div class="quest-panel">
        <p><strong>Quest 3 — The Converging Lines</strong></p>
        <svg width="280" height="200" viewBox="0 0 280 200" xmlns="http://www.w3.org/2000/svg">
            <line x1="140" y1="10" x2="30" y2="190" stroke="#B8B2A8" stroke-width="2"/>
            <line x1="140" y1="10" x2="250" y2="190" stroke="#B8B2A8" stroke-width="2"/>
            <line x1="90" y1="70" x2="190" y2="70" stroke="#FF7A3D" stroke-width="6"/>
            <line x1="70" y1="140" x2="210" y2="140" stroke="#FF7A3D" stroke-width="6"/>
        </svg>
        <details>
            <summary>What's actually happening?</summary>
            <p>Both orange lines are the same length. The converging gray lines look like railway tracks running into the distance, so your brain assumes the lower orange line is "closer" and the upper one must be longer to look the same width from "further away" — even though nothing here is actually 3D.</p>
        </details>
    </div>

    <div class="archive-audio-wrap">
        <p class="eyebrow">Something to listen to while your brain resets</p>
        <audio class="archive-audio" controls>
            <source src="../assets/archive/audio/momin-ambient.mp3" type="audio/mpeg">
        </audio>
        <p><em>No track uploaded yet — drop one in <code>assets/archive/audio/</code> named <code>momin-ambient.mp3</code>, or update the filename above to match whatever gets added.</em></p>
    </div>

    <div class="roast-actions">
        <a class="landing-cta" href="choice.php">Back to the choice</a>
    </div>

    <script src="../assets/js/cursor-follow.js"></script>
</body>
</html>
