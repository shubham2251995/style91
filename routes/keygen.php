<?php
// TEMPORARY KEY GENERATOR - DELETE THIS FILE AFTER USE!
// Visit: yoursite.com/keygen.php

$key = 'base64:' . base64_encode(random_bytes(32));

echo "<html><body style='font-family: monospace; padding: 50px;'>";
echo "<h2>Your APP_KEY:</h2>";
echo "<p style='background: #f0f0f0; padding: 20px; font-size: 16px;'><strong>$key</strong></p>";
echo "<hr>";
echo "<h3>Instructions:</h3>";
echo "<ol>";
echo "<li>Copy the key above</li>";
echo "<li>Open your <code>.env</code> file on the server</li>";
echo "<li>Find the line <code>APP_KEY=</code> and replace it with:<br><code>APP_KEY=$key</code></li>";
echo "<li>Save the file</li>";
echo "<li><strong>DELETE THIS FILE (keygen.php) FOR SECURITY!</strong></li>";
echo "</ol>";
echo "</body></html>";
