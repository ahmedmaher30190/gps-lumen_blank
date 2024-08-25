<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConfigureDatabase extends Command
{
    protected $signature = 'db:configure';
    protected $description = 'Configure the database settings in .env file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dbName = $this->ask('Enter your database name');
        $dbUser = $this->ask('Enter your database user');
        $dbPassword = $this->secret('Enter your database password');

        $envFile = base_path('.env');

        if (!File::exists($envFile)) {
            $this->error('.env file does not exist.');
            return 1;
        }

        $this->updateEnvFile('DB_DATABASE', $dbName);
        $this->updateEnvFile('DB_USERNAME', $dbUser);
        $this->updateEnvFile('DB_PASSWORD', $dbPassword);

        $this->info('Database configuration updated successfully.');

        return 0;
    }

    protected function updateEnvFile($key, $value)
    {
        $envFile = base_path('.env');
        $contents = File::get($envFile);

        if (preg_match('/^' . $key . '=(.*)$/m', $contents, $matches)) {
            $contents = str_replace($matches[0], $key . '=' . $value, $contents);
        } else {
            $contents .= PHP_EOL . $key . '=' . $value;
        }

        File::put($envFile, $contents);
    }
}
