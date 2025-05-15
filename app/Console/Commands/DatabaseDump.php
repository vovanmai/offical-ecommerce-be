<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DatabaseDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump MySQL database to a file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);

        $timestamp = now()->format('Ymd_His');
        $path = storage_path("app/backups/{$database}_{$timestamp}.sql");

        File::ensureDirectoryExists(dirname($path));

        // Build the dump command
        $command = "mysqldump -h {$host} -P {$port} -u {$username} -p\"{$password}\" {$database} > {$path}";

        $this->info("Running command: $command");

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("✅ Database dumped successfully to: {$path}");
        } else {
            $this->error("❌ Failed to dump database.");
        }
    }
}
