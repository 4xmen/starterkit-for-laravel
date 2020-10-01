<?php

namespace Xmen\StarterKit\Commands;

use Illuminate\Console\Command;
use Xmen\StarterKit\StarterKitServiceProvider;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'starter-kit:publish {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all of the starter-kit resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => StarterKitServiceProvider::class,
            '--tag' => 'config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--provider' => StarterKitServiceProvider::class,
            '--tag' => 'assets',
            '--force' => true,
        ]);

        $this->call('vendor:publish', [
            '--provider' => StarterKitServiceProvider::class,
            '--tag' => 'lang',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--provider' => StarterKitServiceProvider::class,
            '--tag' => 'views',
            '--force' => $this->option('force'),
        ]);
        $this->call('vendor:publish', [
            '--provider' => StarterKitServiceProvider::class,
            '--tag' => 'fonts',
            '--force' => $this->option('force'),
        ]);

        $this->call('view:clear');
    }
}
