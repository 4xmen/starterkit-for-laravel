<?php

namespace Xmen\StarterKit\Commands;

use Illuminate\Console\Command;

class StarterKitCommand extends Command
{
    public $signature = 'starter-kit';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
