<?php
/**
 * Production Cache Clear & Optimization Script
 * 
 * Upload this file to your production server root directory
 * Then visit: https://style91.com/fix-production.php
 * 
 * IMPORTANT: Delete this file after use for security!
 */

// Security: Only allow execution from specific IPs (optional)
// Uncomment and add your IP if you want extra security
// $allowed_ips = ['YOUR_IP_HERE'];
// if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
//     die('Access denied');
// }

// Set time limit
set_time_limit(300);

// Output header
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Fix - Style91</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
        }
        h1 {
            color: #667eea;
            margin-top: 0;
            font-size: 28px;
        }
        .step {
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            background: #f8f9fa;
        }
        .success {
            border-left-color: #28a745;
            background: #d4edda;
            color: #155724;
        }
        .error {
            border-left-color: #dc3545;
            background: #f8d7da;
            color: #721c24;
        }
        .warning {
            border-left-color: #ffc107;
            background: #fff3cd;
            color: #856404;
        }
        .command {
            background: #2d3748;
            color: #48bb78;
            padding: 10px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
            overflow-x: auto;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .btn:hover {
            background: #5568d3;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Production Fix Script - Style91</h1>
        <p><strong>This script will clear all Laravel caches and optimize your application.</strong></p>
        
        <?php
        if (isset($_GET['run'])) {
            echo '<div class="step"><strong>Starting fix process...</strong></div>';
            
            $steps = [];
            
            // Step 1: Clear View Cache
            try {
                echo '<div class="command">$ php artisan view:clear</div>';
                $output = shell_exec('cd ' . __DIR__ . ' && php artisan view:clear 2>&1');
                $steps[] = [
                    'title' => 'Clear View Cache',
                    'status' => 'success',
                    'message' => 'Compiled views cleared successfully',
                    'output' => $output
                ];
                echo '<div class="step success">✅ View cache cleared</div>';
            } catch (Exception $e) {
                $steps[] = [
                    'title' => 'Clear View Cache',
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
                echo '<div class="step error">❌ View cache clear failed: ' . $e->getMessage() . '</div>';
            }
            
            // Step 2: Clear Config Cache
            try {
                echo '<div class="command">$ php artisan config:clear</div>';
                $output = shell_exec('cd ' . __DIR__ . ' && php artisan config:clear 2>&1');
                $steps[] = [
                    'title' => 'Clear Config Cache',
                    'status' => 'success',
                    'message' => 'Configuration cache cleared',
                    'output' => $output
                ];
                echo '<div class="step success">✅ Config cache cleared</div>';
            } catch (Exception $e) {
                $steps[] = [
                    'title' => 'Clear Config Cache',
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
                echo '<div class="step error">❌ Config cache clear failed: ' . $e->getMessage() . '</div>';
            }
            
            // Step 3: Clear Route Cache
            try {
                echo '<div class="command">$ php artisan route:clear</div>';
                $output = shell_exec('cd ' . __DIR__ . ' && php artisan route:clear 2>&1');
                $steps[] = [
                    'title' => 'Clear Route Cache',
                    'status' => 'success',
                    'message' => 'Route cache cleared',
                    'output' => $output
                ];
                echo '<div class="step success">✅ Route cache cleared</div>';
            } catch (Exception $e) {
                $steps[] = [
                    'title' => 'Clear Route Cache',
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
                echo '<div class="step error">❌ Route cache clear failed: ' . $e->getMessage() . '</div>';
            }
            
            // Step 4: Clear Application Cache
            try {
                echo '<div class="command">$ php artisan cache:clear</div>';
                $output = shell_exec('cd ' . __DIR__ . ' && php artisan cache:clear 2>&1');
                $steps[] = [
                    'title' => 'Clear Application Cache',
                    'status' => 'success',
                    'message' => 'Application cache cleared',
                    'output' => $output
                ];
                echo '<div class="step success">✅ Application cache cleared</div>';
            } catch (Exception $e) {
                $steps[] = [
                    'title' => 'Clear Application Cache',
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
                echo '<div class="step error">❌ Application cache clear failed: ' . $e->getMessage() . '</div>';
            }
            
            // Step 5: Optimize
            try {
                echo '<div class="command">$ php artisan optimize</div>';
                $output = shell_exec('cd ' . __DIR__ . ' && php artisan optimize 2>&1');
                $steps[] = [
                    'title' => 'Optimize Application',
                    'status' => 'success',
                    'message' => 'Application optimized for production',
                    'output' => $output
                ];
                echo '<div class="step success">✅ Application optimized</div>';
            } catch (Exception $e) {
                $steps[] = [
                    'title' => 'Optimize Application',
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
                echo '<div class="step error">❌ Optimization failed: ' . $e->getMessage() . '</div>';
            }
            
            echo '<div class="step success"><strong>🎉 All tasks completed!</strong></div>';
            echo '<div class="step warning"><strong>⚠️ IMPORTANT:</strong> Please delete this file (fix-production.php) now for security reasons!</div>';
            echo '<a href="/" class="btn">Visit Homepage</a>';
            echo '<a href="?delete=confirm" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this script?\')">Delete This Script</a>';
            
        } elseif (isset($_GET['delete'])) {
            if (@unlink(__FILE__)) {
                echo '<div class="step success">✅ Script deleted successfully! Redirecting to homepage...</div>';
                echo '<script>setTimeout(function(){ window.location.href = "/"; }, 3000);</script>';
            } else {
                echo '<div class="step error">❌ Could not delete script automatically. Please delete it manually via FTP.</div>';
                echo '<p>File location: <code>' . __FILE__ . '</code></p>';
            }
        } else {
            ?>
            <div class="step">
                <h3>What this script will do:</h3>
                <ul>
                    <li>✅ Clear compiled view cache (fixes Blade syntax errors)</li>
                    <li>✅ Clear configuration cache</li>
                    <li>✅ Clear route cache</li>
                    <li>✅ Clear application cache</li>
                    <li>✅ Optimize application for production</li>
                </ul>
            </div>
            
            <div class="step warning">
                <strong>⚠️ Important:</strong> This will clear all cached files and recompile them. This is safe and will fix the production errors.
            </div>
            
            <a href="?run=1" class="btn">🚀 Run Fix Now</a>
            
            <div class="step" style="margin-top: 30px;">
                <h3>Manual Alternative (via SSH):</h3>
                <div class="command">
cd /home/u263595993/domains/style91.com/public_html<br>
php artisan view:clear<br>
php artisan config:clear<br>
php artisan route:clear<br>
php artisan cache:clear<br>
php artisan optimize
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
