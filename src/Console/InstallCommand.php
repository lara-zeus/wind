<?php

namespace LaraZeus\Wind\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wind:install {--force : Overwrite any existing files}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Wind components and resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // art vendor:publish --tag=zeus-wind-migrations
        // publish Wind files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-config', '--force' => $this->option('force') ?? false]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-migrations', '--force' => $this->option('force') ?? false]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-views', '--force' => $this->option('force') ?? false]);

        $this->callSilent('vendor:publish', ['--tag' => 'wind-seeder', '--force' => $this->option('force') ?? false]);
        $this->callSilent('vendor:publish', ['--tag' => 'wind-factories', '--force' => $this->option('force') ?? false]);

        // publish Zeus files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-config', '--force' => $this->option('force') ?? false]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-views', '--force' => $this->option('force') ?? false]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-assets', '--force' => $this->option('force') ?? false]);

        $this->callSilent('migrate');

        $this->output->success('Zeus Wind has been installed successfully');
    }
}