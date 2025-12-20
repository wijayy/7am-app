<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateSqliteToMysqlSeeder extends Seeder
{
    /**
     * Migrate data from SQLite to MySQL for specified tables.
     *
     * Usage:
     *   $this->call(MigrateSqliteToMysqlSeeder::class);
     *
     * Then in DatabaseSeeder.php, add tables to migrate in the migrateAllTables() call
     */

    /**
     * Migrate a single table from SQLite to MySQL
     */
    public function migrateTable($tableName)
    {
        try {
            $rows = DB::connection('sqlite')->table($tableName)->get();

            if ($rows->isEmpty()) {
                $this->command->info("No data found in SQLite table: {$tableName}");
                return;
            }

            // Clear existing data in MySQL table (optional, uncomment if needed)
            // DB::connection('mysql')->table($tableName)->truncate();

            $rows->each(function ($row) use ($tableName) {
                DB::connection('mysql')->table($tableName)->insert((array)$row);
            });

            $this->command->info("✓ Migrated " . $rows->count() . " records from SQLite {$tableName} to MySQL");
        } catch (\Throwable $e) {
            $this->command->error("✗ Error migrating {$tableName}: " . $e->getMessage());
        }
    }

    /**
     * Migrate multiple tables at once
     */
    public function migrateAllTables(array $tables)
    {
        $this->command->info("Starting migration from SQLite to MySQL...");

        foreach ($tables as $table) {
            $this->migrateTable($table);
        }

        $this->command->info("Migration completed!");
    }

    public function run(): void
    {
        // Dynamically get all tables from SQLite
        $tablesToMigrate = DB::connection('sqlite')
            ->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

        if (empty($tablesToMigrate)) {
            $this->command->warn("No tables found in SQLite database");
            return;
        }

        // Extract table names from results
        $tableNames = array_map(function ($table) {
            return $table->name;
        }, $tablesToMigrate);

        $this->migrateAllTables($tableNames);
    }
}