<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class LaravelZeroInstaller extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install:laravelzero
                            {name : The name of your new Laravel Zero Application (Required)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a fresh installation of Laravel Zero.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the name of the project
        $name = $this->argument('name');

        $this->info('Creating a new Laravel Zerp application in ./'.$name . ' ...');


        $taskone = $this->task('Installing Laravel Zero', function () use (&$name) {

            // Run shell_exec for composer.
            $zeroInstall = shell_exec('composer create-project laravel-zero/laravel-zero ' . $name);

            return true;
        });

        $this->task('Renaming project', function () use (&$name) {
            $zeroRename = shell_exec('cd ' . $name . ' && php application app:rename ' . $name);

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
