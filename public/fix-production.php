<?php
/**
 * Production Cache Clear & Optimization Script (Artisan Version)
 * 
 * Uses Laravel's internal Artisan command runner to bypass shell restrictions.
 * 
 * For local testing: http://localhost:8000/fix-production.php
 * For production: https://style91.com/fix-production.php
 * 
 * IMPORTANT: Delete this file after use for security!
 */

// Security: Only allow execution from specific IPs (optional)
// $allowed_ips = ['YOUR_IP_HERE'];
// if (!in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
//     die('Access denied');
// }

// Set time limit
set_time_limit(300);

// Define base path
$basePath = dirname(__DIR__);

// Bootstrap Laravel
require $basePath . '/vendor/autoload.php';
$app = require_once $basePath . '/bootstrap/app.php';

// Make the kernel to bootstrap the application (load service providers, etc.)
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
        }
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 32px;
            font-weight: 700;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .step {
            padding: 16px;
            margin: 12px 0;
            border-radius: 8px;
            border-left: 5px solid #667eea;
            background: #f8f9fa;
            font-size: 14px;
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
        .command {
            background: #2d3748;
            color: #48bb78;
            padding: 12px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin: 10px 0;
            overflow-x: auto;
            line-height: 1.6;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Production Fix Script (Internal)</h1>
        <p class="subtitle">Using Laravel Artisan directly (Bypassing Shell)</p>
        
        <?php
        if (isset($_GET['run'])) {
            echo '<div class="step info"><strong>⚙️ Starting fix process...</strong></div>';
            
            $commands = [
                'view:clear' => 'Clearing View Cache',
                'config:clear' => 'Clearing Config Cache',
                'route:clear' => 'Clearing Route Cache',
                'cache:clear' => 'Clearing Application Cache',
                'optimize' => 'Optimizing Application'
            ];
            
            $allSuccess = true;
            
            foreach ($commands as $command => $label) {
                try {
                    echo '<div class="command">$ php artisan ' . $command . '</div>';
                    
                    // Run command using Artisan facade
                    $exitCode = Artisan::call($command);
                    $output = Artisan::output();
                    
                    if ($exitCode === 0) {
                        echo '<div class="step success">✅ <strong>' . $label . ' Success</strong><br><pre>' . htmlspecialchars($output) . '</pre></div>';
                    } else {
                        $allSuccess = false;
                        echo '<div class="step error">❌ <strong>' . $label . ' Failed</strong> (Exit Code: ' . $exitCode . ')<br><pre>' . htmlspecialchars($output) . '</pre></div>';
                    }
                } catch (Exception $e) {
                    $allSuccess = false;
                    echo '<div class="step error">❌ <strong>' . $label . ' Exception:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
                }
            }
            
            if ($allSuccess) {
                echo '<div class="step success"><strong>🎉 All tasks completed successfully!</strong></div>';
            } else {
                echo '<div class="step warning"><strong>⚠️ Some tasks failed. Check the errors above.</strong></div>';
            }
            
            echo '<div style="text-align: center; margin-top: 30px;">';
            echo '<a href="/" class="btn btn-success">✓ Visit Homepage</a>';
            echo '<a href="?delete=confirm" class="btn btn-danger" onclick="return confirm(\'Delete this script now?\')">🗑 Delete Script</a>';
            echo '</div>';
            
        } elseif (isset($_GET['delete'])) {
            if (@unlink(__FILE__)) {
                echo '<div class="step success">✅ <strong>Script deleted successfully!</strong><br>Redirecting to homepage...</div>';
                echo '<script>setTimeout(function(){ window.location.href = "/"; }, 3000);</script>';
            } else {
                echo '<div class="step error">❌ <strong>Auto-delete failed</strong><br>Please delete manually via FTP.</div>';
            }
        } else {
            ?>
            <div class="step info">
                <h3>📋 Improved Fix Script:</h3>
                <p>This version runs commands internally within Laravel, bypassing shell restrictions that caused the previous version to hang.</p>
            </div>
            
            <div style="text-align: center;">
                <a href="?run=1" class="btn">🚀 Run Fix Now</a>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>
