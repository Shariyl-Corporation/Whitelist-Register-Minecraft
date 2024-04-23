<?php

namespace App\Console;

use App\Models\ConnectionLog;
use App\Models\Server;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        Log::info('Appending Schedules');

        $schedule->call(function () {
            Log::info('Starting ping');

            foreach (Server::all() as $server) {
                Log::info("Pinging $server->name");
                
                // Start timer
                $start = microtime(true);

                // Open TCP connection
                $socket = fsockopen($server->ip, $server->port, $errno, $errstr, 5);

                // Check if connection was successful
                if ($socket) {
                    // Connection successful, calculate latency
                    $latency = microtime(true) - $start;
                    fclose($socket);
                    ConnectionLog::factory()->create([
                        'server_id' => $server->id,
                        'alive' => true,
                        'pingms' => $latency,
                    ]);
                } else {
                    // Connection failed
                    ConnectionLog::factory()->create([
                        'server_id' => $server->id,
                        'alive' => false,
                    ]);
                }
                Log::info("Pinged $server->name : $latency");
            }
            Log::info('Done ping');
        })->everyThirtySeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
