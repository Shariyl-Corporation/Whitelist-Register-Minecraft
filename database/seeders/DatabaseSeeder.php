<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $ServerSeeder = '\Database\Seeders\ServerSeeder';
        $run = 'run';
        
        if (class_exists($ServerSeeder) && method_exists($ServerSeeder, $run)) {
            call_user_func([$ServerSeeder, $run]);
        } else {
            $this->command->warn("Class $ServerSeeder is not exist, please create one to populate the servers table.");
        }
    }
}
