<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Create menus table
    if (!Schema::hasTable('menus')) {
        DB::statement('CREATE TABLE menus (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            location VARCHAR(255) NULL,
            created_at DATETIME NULL,
            updated_at DATETIME NULL
        )');
        echo "Created menus table.\n";
    } else {
        echo "menus table already exists.\n";
    }

    // Create menu_items table
    if (!Schema::hasTable('menu_items')) {
        DB::statement('CREATE TABLE menu_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            menu_id INTEGER NOT NULL,
            title VARCHAR(255) NOT NULL,
            url VARCHAR(255) NULL,
            route VARCHAR(255) NULL,
            parameters TEXT NULL,
            parent_id INTEGER NULL,
            "order" INTEGER DEFAULT 0,
            target VARCHAR(255) DEFAULT "_self",
            created_at DATETIME NULL,
            updated_at DATETIME NULL,
            FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE,
            FOREIGN KEY (parent_id) REFERENCES menu_items(id) ON DELETE CASCADE
        )');
        echo "Created menu_items table.\n";
    } else {
        echo "menu_items table already exists.\n";
    }

    // Mark migration as run
    $migrationName = '2025_11_28_000003_create_menus_table';
    $exists = DB::table('migrations')->where('migration', $migrationName)->exists();
    if (!$exists) {
        DB::table('migrations')->insert([
            'migration' => $migrationName,
            'batch' => DB::table('migrations')->max('batch') + 1
        ]);
        echo "Marked migration as run.\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
