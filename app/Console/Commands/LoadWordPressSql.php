<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadWordPressSql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wp:load-sql {file? : The path to the WordPress SQL file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load raw WordPress SQL file into the wordpress database connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file') ?? 'D:\\FTP\\bholatimes\\Old_DB\\bilssknx_wp634.sql';

        if (!file_exists($filePath)) {
            $this->error("SQL file not found at: {$filePath}");
            return Command::FAILURE;
        }

        $this->info("Starting to import raw SQL file: {$filePath}");

        // Retrieve connection parameters
        $config = config('database.connections.wordpress');
        if (!$config) {
            $this->error("WordPress database connection not configured in config/database.php");
            return Command::FAILURE;
        }

        $dbName = $config['database'];
        $host = $config['host'];
        $port = $config['port'];
        $username = $config['username'];
        $password = $config['password'];

        $this->info("Ensuring a clean slate: Dropping and re-creating database '{$dbName}'...");
        try {
            $pdo = new \PDO("mysql:host={$host};port={$port}", $username, $password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->exec("DROP DATABASE IF EXISTS `{$dbName}`;");
            $pdo->exec("CREATE DATABASE `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            
            // Programmatically boost max_allowed_packet to 128MB
            $this->info("Boosting MySQL performance settings (setting max_allowed_packet to 128MB)...");
            try {
                $pdo->exec("SET GLOBAL max_allowed_packet=134217728;");
                $this->info("MySQL max_allowed_packet successfully set to 128MB globally.");
            } catch (\Exception $packetEx) {
                $this->warn("Warning: Could not set max_allowed_packet globally: " . $packetEx->getMessage() . ". If massive queries fail, you may need to manually add 'max_allowed_packet=128M' in your MySQL configuration file (my.ini).");
            }
            
            $this->info("Database '{$dbName}' verified/created successfully.");
        } catch (\Exception $e) {
            $this->error("Failed to connect or create database: " . $e->getMessage());
            return Command::FAILURE;
        }

        // Purge Laravel connection cache so that it re-connects and inherits the new max_allowed_packet size!
        DB::purge('wordpress');

        // Open the SQL file
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->error("Could not open SQL file at {$filePath}");
            return Command::FAILURE;
        }

        $this->info("Parsing and running SQL queries...");
        
        // Re-establish Laravel's WP connection and get PDO
        $conn = DB::connection('wordpress');
        $pdo = $conn->getPdo();
        
        // Adjust connection timeouts to prevent premature disconnects
        try {
            $pdo->exec("SET SESSION wait_timeout=3600;");
            $pdo->exec("SET SESSION interactive_timeout=3600;");
        } catch (\Exception $e) {
            // Ignore if session variables cannot be tuned
        }
        
        $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");

        $sql = '';
        $queryCount = 0;
        $fileSize = filesize($filePath);
        $bar = $this->output->createProgressBar($fileSize);
        $bar->start();

        while (($line = fgets($handle)) !== false) {
            $bytesRead = strlen($line);
            $bar->advance($bytesRead);

            $trimmed = trim($line);
            
            // Skip comments and empty lines
            if ($trimmed === '' || str_starts_with($trimmed, '--') || str_starts_with($trimmed, '#') || str_starts_with($trimmed, '/*')) {
                continue;
            }

            $sql .= $line;

            // Execute SQL when statement ends with semicolon
            if (str_ends_with($trimmed, ';')) {
                try {
                    $pdo->exec($sql);
                    $queryCount++;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->warn("Warning: Skipped query due to error. Error: " . $e->getMessage() . "\nQuery snippet: " . substr(trim($sql), 0, 150));
                }
                $sql = '';
            }
        }

        fclose($handle);
        $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
        $bar->finish();
        
        $this->newLine();
        $this->info("Successfully loaded WordPress SQL! {$queryCount} queries executed.");
        return Command::SUCCESS;
    }
}
