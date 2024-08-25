<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateSecretKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:secret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new secret x-api-key';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Generate a new random key
        $key = Str::random(100);

        // Display the generated key in the console
        $this->info("Your new secret x-api-key is: {$key}");

        // Path to the .env file
        $path = base_path('.env');

        // Check if .env file exists
        if (file_exists($path)) {
            // Replace or add the X_API_KEY value in the .env file
            if (strpos(file_get_contents($path), 'X_API_KEY=') !== false) {
                file_put_contents($path, str_replace(
                    'X_API_KEY=' . env('X_API_KEY'),
                    'X_API_KEY=' . $key,
                    file_get_contents($path)
                ));
            } else {
                // If X_API_KEY doesn't exist, add it to the .env file
                file_put_contents($path, PHP_EOL . "X_API_KEY={$key}", FILE_APPEND);
            }

            $this->info('Secret x-api-key set successfully in .env');
        } else {
            $this->error('The .env file does not exist.');
        }
    }
}
