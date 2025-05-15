<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ImageKit\ImageKit;

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

        try {
            $this->info('Starting database dump...');
            $startTime = now()->format('Y-m-d H:i:s');
            Log::info("[START] Database dump started at: {$startTime}");
            $this->dumpDatabase();
            $endTime = now()->format('Y-m-d H:i:s');
            Log::info("[END] Database dump completed at: {$endTime}");
            $this->info('Database dump completed successfully.');
        } catch (\Exception $e) {
            $this->error('Database dump error: ' . $e->getMessage());
            Log::error('Database dump error: ' . $e->getMessage());
        }
    }

    /**
     * Dump the database using the mysqldump command.
     *
     * @return void
     */
    protected function dumpDatabase()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);

        $timestamp = now()->format('Ymd_His');
        $filename = "{$database}_{$timestamp}.sql";

        $path = storage_path("app/backups/{$filename}");

        File::ensureDirectoryExists(dirname($path));

        // Build the dump command
        $command = "mysqldump -h {$host} -P {$port} -u {$username} -p\"{$password}\" {$database} > {$path}";

        $this->info("Running command: $command");

        $result = null;
        $output = null;
        exec($command, $output, $result);

        $this->info("Đã run: {$command}");

        if ($result === 0) {
            $this->info("✅ Database dumped successfully to: {$path}");
        } else {
            $this->error("❌ Failed to dump database.");
        }

        $imageKit = new ImageKit(
            config('filesystems.imagekit.public_key'),
            config('filesystems.imagekit.private_key'),
            config('filesystems.imagekit.url_endpoint'),
        );

        $fileData = file_get_contents($path);

        $folder = config('filesystems.imagekit.folder');

        $imageKit->uploadFile([
            'file' => base64_encode($fileData),
            'fileName' => $filename,
            'folder' => $folder . '/backup_db',
        ]);
    }
}
