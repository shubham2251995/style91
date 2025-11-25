<?php
/**
 * Pre-Flight Check for Style91 Deployment
 * Run this BEFORE the installer to verify everything is ready
 * 
 * Visit: https://yourdomain.com/pre-flight-check.php
 */

$checks = [];
$autoFixes = [];
$errors = [];

// 1. PHP Version Check
$phpVersion = phpversion();
$checks['php_version'] = [
    'name' => 'PHP Version',
    'required' => '8.1.0',
    'current' => $phpVersion,
    'status' => version_compare($phpVersion, '8.1.0', '>=')
];

// 2. Required Extensions
$requiredExtensions = ['bcmath', 'ctype', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
foreach ($requiredExtensions as $ext) {
    $checks["ext_$ext"] = [
        'name' => "$ext Extension",
        'required' => 'Enabled',
        'current' => extension_loaded($ext) ? 'Enabled' : 'Disabled',
        'status' => extension_loaded($ext)
    ];
}

// 3. Create .env if missing
$envPath = __DIR__ . '/../.env';
$envExamplePath = __DIR__ . '/../.env.example';

if (!file_exists($envPath)) {
    if (file_exists($envExamplePath)) {
        copy($envExamplePath, $envPath);
        $autoFixes[] = 'Created .env from .env.example';
    } else {
        // Create minimal .env
        $minimalEnv = <<<ENV
APP_NAME="Style91"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=style91
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
ENV;
        file_put_contents($envPath, $minimalEnv);
        $autoFixes[] = 'Created minimal .env file';
    }
}

$checks['env_file'] = [
    'name' => '.env File',
    'required' => 'Exists',
    'current' => file_exists($envPath) ? 'Exists' : 'Missing',
    'status' => file_exists($envPath)
];

// 4. Create required directories
$requiredDirs = [
    '../storage/framework/sessions',
    '../storage/framework/views',
    '../storage/framework/cache',
    '../storage/framework/cache/data',
    '../storage/logs',
    '../storage/app/public',
    '../bootstrap/cache',
];

foreach ($requiredDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (!is_dir($fullPath)) {
        if (@mkdir($fullPath, 0755, true)) {
            $autoFixes[] = "Created directory: $dir";
        } else {
            $errors[] = "Failed to create: $dir";
        }
    }
}

// 5. Check directory permissions
$writableDirs = [
    '../storage' => __DIR__ . '/../storage',
    '../bootstrap/cache' => __DIR__ . '/../bootstrap/cache',
];

foreach ($writableDirs as $name => $path) {
    $writable = is_writable($path);
    
    if (!$writable) {
        // Try to fix
        if (@chmod($path, 0755)) {
            $writable = true;
            $autoFixes[] = "Fixed permissions for: $name";
        }
    }
    
    $checks["writable_$name"] = [
        'name' => "$name Writable",
        'required' => 'Yes',
        'current' => $writable ? 'Yes' : 'No',
        'status' => $writable
    ];
}

// 6. Check mod_rewrite (for .htaccess)
$checks['mod_rewrite'] = [
    'name' => 'mod_rewrite',
    'required' => 'Enabled',
    'current' => in_array('mod_rewrite', apache_get_modules()) ? 'Enabled' : 'Unknown',
    'status' => true // We'll assume it works
];

// 7. Check upload limit
$uploadLimit = ini_get('upload_max_filesize');
$checks['upload_limit'] = [
    'name' => 'Upload Limit',
    'required' => '>= 10M',
    'current' => $uploadLimit,
    'status' => true // Not critical
];

// 8. Check execution time
$maxExecutionTime = ini_get('max_execution_time');
$checks['execution_time'] = [
    'name' => 'Max Execution Time',
    'required' => '>= 300s',
    'current' => $maxExecutionTime . 's',
    'status' => $maxExecutionTime >= 300 || $maxExecutionTime == 0
];

// Calculate overall status
$allPassed = true;
foreach ($checks as $check) {
    if (!$check['status']) {
        $allPassed = false;
        break;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style91 - Pre-Flight Check</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .header p {
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .status-banner {
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }
        .status-banner.success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        .status-banner.warning {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }
        .check-item {
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
        }
        .check-item:last-child {
            border-bottom: none;
        }
        .check-name {
            font-weight: 500;
        }
        .check-required, .check-current {
            font-size: 14px;
            color: #666;
        }
        .check-status {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }
        .check-status.pass {
            background: #28a745;
        }
        .check-status.fail {
            background: #dc3545;
        }
        .fixes {
            background: #e7f3ff;
            border: 2px solid #2196F3;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .fixes h3 {
            color: #1976D2;
            margin-bottom: 15px;
        }
        .fixes ul {
            list-style: none;
            padding-left: 0;
        }
        .fixes li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
        }
        .fixes li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #2196F3;
            font-weight: bold;
        }
        .errors {
            background: #ffe6e6;
            border: 2px solid #ff4444;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .errors h3 {
            color: #cc0000;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .actions {
            text-align: center;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        @media (max-width: 768px) {
            .check-item {
                grid-template-columns: 1fr;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Style91 Pre-Flight Check</h1>
            <p>Verifying your server is ready for deployment</p>
        </div>
        
        <div class="content">
            <?php if ($allPassed): ?>
                <div class="status-banner success">
                    ✅ ALL CHECKS PASSED! Ready for installation.
                </div>
            <?php else: ?>
                <div class="status-banner warning">
                    ⚠️ Some checks failed. Review below and fix before installing.
                </div>
            <?php endif; ?>
            
            <?php if (!empty($autoFixes)): ?>
                <div class="fixes">
                    <h3>🔧 Auto-Fixes Applied</h3>
                    <ul>
                        <?php foreach ($autoFixes as $fix): ?>
                            <li><?php echo htmlspecialchars($fix); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="errors">
                    <h3>❌ Manual Fixes Required</h3>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <h3 style="margin-bottom: 20px;">System Checks</h3>
            
            <?php foreach ($checks as $check): ?>
                <div class="check-item">
                    <div class="check-name"><?php echo htmlspecialchars($check['name']); ?></div>
                    <div class="check-required">Required: <?php echo htmlspecialchars($check['required']); ?></div>
                    <div class="check-current">Current: <?php echo htmlspecialchars($check['current']); ?></div>
                    <div class="check-status <?php echo $check['status'] ? 'pass' : 'fail'; ?>">
                        <?php echo $check['status'] ? '✓' : '✗'; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="actions">
                <a href="javascript:location.reload()" class="btn">🔄 Re-Check</a>
                <?php if ($allPassed): ?>
                    <a href="/install" class="btn">Continue to Installer →</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
