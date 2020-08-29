<?php

namespace Xmen\StarterKit\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class StarterKitCommand extends Command
{
    public $signature = 'starter-kit:install';

    public $description = 'Install Starter Kit';

    public function handle()
    {
        $this->info('Create Admin User');

        $role = Role::create(['name' => 'super-admin']);
        $mrole = Role::create(['name' => 'manager']);

        $user = new \App\User();
        $user->email=$this->ask('Enter Email:','admin@example.com');
        $user->name=$this->ask('Enter name:','admin');
        $user->password=bcrypt($this->ask('Enter password','password'));
        $user->assignRole($role);
        $user->save();

        $this->info('Admin created. Now login '.route('login'));

        return 0;
    }
}
