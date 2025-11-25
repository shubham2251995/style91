<?php

/**
 * EMERGENCY APP_KEY GENERATOR
 * This file runs BEFORE Laravel boots and ensures APP_KEY exists
 * Also forces MySQL connection to prevent SQLite errors
 * Place this at the very top of public/index.php
 */

// Only run if APP_KEY is missing
$envPath = __DIR__.'/../.env';

if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $modified = false;
    
    // Check if APP_KEY is empty or missing
    if (preg_match('/^APP_KEY=\s*$/m', $envContent) || !str_contains($envContent, 'APP_KEY=')) {
        // Generate a new key
        $key = 'base64:' . base64_encode(random_bytes(32));
        
        // Update or add APP_KEY
        if (str_contains($envContent, 'APP_KEY=')) {
            $envContent = preg_replace('/^APP_KEY=.*$/m', 'APP_KEY=' . $key, $envContent);
        } else {
            $envContent = "APP_KEY=$key\n" . $envContent;
        }
        $modified = true;
    }
    
    // FORCE MYSQL CONNECTION (prevent SQLite errors)
    if (str_contains($envContent, 'DB_CONNECTION=sqlite') || preg_match('/^DB_CONNECTION=\s*$/m', $envContent)) {
        $envContent = preg_replace('/^DB_CONNECTION=.*$/m', 'DB_CONNECTION=mysql', $envContent);
        $modified = true;
    } elseif (!str_contains($envContent, 'DB_CONNECTION=')) {
        // Add DB_CONNECTION if missing
        $envContent = "DB_CONNECTION=mysql\n" . $envContent;
        $modified = true;
    }
    
    // FORCE FILE SESSIONS during installation (prevent missing 'sessions' table error)
    $installedFile = __DIR__ . '/../storage/installed';
    if (!file_exists($installedFile)) {
        // Not installed yet, use file sessions
        if (str_contains($envContent, 'SESSION_DRIVER=database')) {
            $envContent = preg_replace('/^SESSION_DRIVER=.*$/m', 'SESSION_DRIVER=file', $envContent);
            $modified = true;
        } elseif (!str_contains($envContent, 'SESSION_DRIVER=')) {
            $envContent = "SESSION_DRIVER=file\n" . $envContent;
            $modified = true;
        }
    }
    
    // Write back if modified
    if ($modified) {
        file_put_contents($envPath, $envContent);
    }
}
