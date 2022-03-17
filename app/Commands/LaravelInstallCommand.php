<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class LaravelInstallCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install:laravel
                            {name : The name of your new Laravel Application (Required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a fresh installation of Laravel.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the name of the project
        $name = $this->argument('name');

        $this->info('Creating a new Laravel application in ./'.$name . ' ...');


        $this->task('Installing Laravel', function () use (&$name) {

            // Run shell_exec for composer.
            $laravelInstall = shell_exec('composer create-project laravel/laravel ' . $name);

            return true;
        });
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
