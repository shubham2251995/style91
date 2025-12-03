<?php
/**
 * Admin User Creation Script
 * 
 * Run this file ONCE to create an admin user.
 * After creating the admin, DELETE this file for security.
 * 
 * Usage: Place in public folder and visit: https://yoursite.com/create-admin.php
 */

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Configuration - CHANGE THESE VALUES
$adminEmail = 'admin@style91.com';
$adminPassword = 'Admin@123456';  // Change this to a strong password
$adminName = 'Admin';

try {
    // Check if admin already exists
    $existingAdmin = User::where('email', $adminEmail)->first();
    
    if ($existingAdmin) {
        // Update existing user to admin
        $existingAdmin->update([
            'role' => 'admin',
            'password' => Hash::make($adminPassword)
        ]);
        
        echo "<h1>Success!</h1>";
        echo "<p>Existing user <strong>{$adminEmail}</strong> has been updated to admin role.</p>";
        echo "<p><strong>Password:</strong> {$adminPassword}</p>";
    } else {
        // Create new admin user
        $admin = User::create([
            'name' => $adminName,
            'email' => $adminEmail,
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
            'email_verified_at' => now(),
            'onboarding_completed' => true,
            'onboarding_completed_at' => now(),
        ]);
        
        echo "<h1>Success!</h1>";
        echo "<p>Admin user created successfully!</p>";
        echo "<p><strong>Email:</strong> {$adminEmail}</p>";
        echo "<p><strong>Password:</strong> {$adminPassword}</p>";
    }
    
    echo "<hr>";
    echo "<p style='color: red;'><strong>IMPORTANT:</strong> DELETE this file (create-admin.php) immediately for security!</p>";
    echo "<p><a href='/admin/login'>Go to Admin Login →</a></p>";
    
} catch (\Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
