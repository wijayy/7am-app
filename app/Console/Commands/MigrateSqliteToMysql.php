<?php

namespace App\Console\Commands;

use Database\Seeders\MigrateSqliteToMysqlSeeder;
use Illuminate\Console\Command;

class MigrateSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:sqlite-to-mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all tables from SQLite to MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting SQLite to MySQL migration...');
        $this->newLine();

        try {
            $seeder = new MigrateSqliteToMysqlSeeder();
            $seeder->setCommand($this);
            $seeder->run();

            $this->newLine();
            $this->info('✅ Migration completed successfully!');
            return 0;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('❌ Migration failed: ' . $e->getMessage());
            return 1;
        }
    }
}
