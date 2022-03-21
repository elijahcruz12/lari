<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use LaravelZero\Framework\Commands\Command;
use Nadar\PhpComposerReader\ComposerReader;
use Nadar\PhpComposerReader\RequireSection;

class TallStackInstaller extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install:tall
                            {--all}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Install a TALL stack. Add the -all flag to also install Laravel.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // First we must verify that this is a Laravel installer
        $this->task('Checking for composer.json', function() {

            if(!file_exists(getcwd() . '/composer.json')){
                $this->error('No composer.json found. Ensure you\'re at the root directory');
                return false;
            }

            return true;
        });

        $this->task('Checking for Laraven Install', function() {
            $reader = new ComposerReader(getcwd() . '/composer.json');
            if (!$reader->canRead()) {
                throw new \Exception("Unable to read json.");
            }

            $section = new RequireSection($reader);

            foreach($section as $package) {
                $this->info( $package->name . ' with ' . $package->constraint);

                if($package->name == 'laravel/framework') {
                    return true;
                }
            }

            $this->error('laravel/framework not found in require section of composer.json');
            return false;
        });

        $this->task('Checking if npm is installed.', function () {
            exec('npm -v', $foo, $exitCode);

            if ($exitCode !== 0) {
                $this->error('NPM must be installed');
                return false;
            }

            return true;
        });

        if($this->confirm('Are you sure you want to install the TALL Stack?')){
            // Start on the TALL Stack

            $installAll = $this->argument('all');

            if($installAll == true){

                $projectName = $this->ask('What is the name of your new Laravel Application?');

                if($projectName == null){
                    return;
                }

                // Create the Laravel Install
                Artisan::call('install:laravel', [
                    'name' =>$projectName
                ]);
            }
            else {
                if(!$this->confirm('Is this a fresh Laravel installation?')){
                    return;
                }
            }

            // Add Livewire

            // Install Alpine

            // Install Tailwind
        }
        else {
            return;
        }
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
