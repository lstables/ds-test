<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'darkside:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application along with seeders and migrations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->comment('Building...');

        // Wipe DB
        $this->callSilent('db:wipe', ['--force' => true]);

        // Run the migrations
        $this->comment('Migrating database');
        $this->call('migrate:fresh');

        $this->info('Database installed!');

        // Run the seeders
        $this->comment('Seeding database');
        $this->call('db:seed');
        $this->info('Database seeded!');

        sleep(2);

        $this->info('Complete, all setup!');
    }
}
