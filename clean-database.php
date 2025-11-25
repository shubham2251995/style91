<?php
// Direct database cleanup script - bypasses all caching
// Run this before using the installer

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Get database credentials from .env
    $host = env('DB_HOST', '127.0.0.1');
    $port = env('DB_PORT', '3306');
    $database = env('DB_DATABASE', 'style91');
    $username = env('DB_USERNAME', 'root');
    $password = env('DB_PASSWORD', '');

    // Direct PDO connection (bypasses Laravel cache)
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$database}",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "Connected to database: {$database}\n\n";

    // Disable foreign key checks
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');

    // Get all tables
    $stmt = $pdo->query('SHOW TABLES');
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($tables)) {
        echo "No tables to drop.\n";
    } else {
        echo "Found " . count($tables) . " tables. Dropping...\n\n";
        
        foreach ($tables as $table) {
            $pdo->exec("DROP TABLE IF EXISTS `{$table}`");
            echo "✓ Dropped: {$table}\n";
        }
        
        echo "\n✅ All tables dropped successfully!\n";
    }

    // Re-enable foreign key checks
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');

    echo "\n🎯 Database is now clean. You can run the installer at /install\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
