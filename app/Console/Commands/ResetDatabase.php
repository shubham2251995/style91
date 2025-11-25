<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetDatabase extends Command
{
    protected $signature = 'db:reset';
    protected $description = 'Drop all tables from the database';

    public function handle()
    {
        if (!$this->confirm('This will drop ALL tables. Are you sure?')) {
            return;
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            $tables = DB::select('SHOW TABLES');
            
            if (empty($tables)) {
                $this->info('No tables to drop.');
                return;
            }
            
            $firstTable = (array) $tables[0];
            $columnName = array_keys($firstTable)[0];
            
            $this->info('Dropping tables...');
            
            foreach ($tables as $table) {
                $tableArray = (array) $table;
                $tableName = $tableArray[$columnName];
                
                DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                $this->line("Dropped: {$tableName}");
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            $this->info('All tables dropped successfully!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
