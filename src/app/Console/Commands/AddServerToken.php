<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ServersToken;
use Illuminate\Support\Str;

class AddServerToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:server {--ip=} {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new server with a generated token';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $serverIp = $this->option('ip');
        $serverName = $this->option('name');

        if (empty($serverIp) || empty($serverName)) {
            $this->error('Both IP and Name options are required.');
            return;
        }

        // Check if the server IP already exists
        if (ServersToken::where('server_ip', $serverIp)->exists()) {
            $this->error('A server with this IP already exists.');
            return;
        }

        // Create the server token
        $token = new ServersToken;
        $token->server_name = $serverName;
        $token->server_ip = $serverIp;
        $token->server_token = Str::random(40);
        $token->save();

        // Optionally append additional characters to the token
        $token->server_token .= Str::random(20);
        $token->save();

        $hashedData = base64_encode($token);

        $this->info("Server added successfully!");
        $this->info("Server Token: {$hashedData}");
    }
}
