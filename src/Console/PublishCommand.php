<?php

namespace LaraZeus\Wind\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wind:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PublishCommand all Zeus and Wind components and resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // publish Wind files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-config', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-migrations', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-views', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-translations', '--force' => (bool) $this->option('force')]);

        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-seeder', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-wind-factories', '--force' => (bool) $this->option('force')]);

        // publish Zeus files
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-config', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-views', '--force' => (bool) $this->option('force')]);
        $this->callSilent('vendor:publish', ['--tag' => 'zeus-assets', '--force' => (bool) $this->option('force')]);

        $this->output->success('Zeus and Wind has been Published successfully');
    }
}
