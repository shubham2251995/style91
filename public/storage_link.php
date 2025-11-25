<?php

$target = __DIR__ . '/../style91_core/storage/app/public';
$shortcut = __DIR__ . '/storage';

if (file_exists($shortcut)) {
    echo "Storage link already exists!";
} else {
    if (symlink($target, $shortcut)) {
        echo "Symlink Created Successfully!";
    } else {
        echo "Failed to create symlink. Ensure your path is correct and you have permissions.";
        echo "<br>Target: " . $target;
        echo "<br>Shortcut: " . $shortcut;
    }
}
