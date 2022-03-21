<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Nadar\PhpComposerReader\ComposerReader;
use Nadar\PhpComposerReader\RequireSection;

class TailwindInstaller extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install:tailwind';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Install Tailwind on a fresh installation';

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

        if ($this->confirm('This may only be used on a FRESH laravel installation. Do you wish to continue?')) {
            // Start installing Tailwind
            $this->task('Installing TailwindCSS...', function () {
                $this->info('Running npm install');
                exec('npm install -D tailwindcss postcss autoprefixer');

                $this->info('running npx tailwindcss init');
                exec("npx tailwindcss init");

                $this->info('Adding tailwind.config.js');
                copy(__DIR__ . '/../../stubs/tailwind/tailwind.config.js.stub', './tailwind.config.js');

                $this->info('Updating webpack.mix.js');
                copy(__DIR__ . '/../../stubs/tailwind/webpack.mix.js.stub', './webpack.mix.js');

                $this->info('Updating welcome.blade.php');
                copy(__DIR__ . '/../../stubs/tailwind/app.blade.php.stub', './resources/views/welcome.blade.php');

                $this->info('Updating app.css');
                copy(__DIR__ . '/../../stubs/tailwind/app.css.stub', './resources/css/app.css');

                $this->info('Running npx mix');
                exec('npx mix');
                // Ran twice as sometimes makes you restart it.
                exec('npx mix');

                $this->info('Tailwind Installed on this application.');
            });
        }
        else return;
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
