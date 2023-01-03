<?php

namespace Xmen\StarterKit\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Spatie\Permission\Models\Role;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class StarterKitCommand extends Command
{
    public $signature = 'starter-kit:install';

    public $description = 'Install Starter Kit';

    public function handle()
    {
        $this->info('Create Admin User');

        $role = Role::FirstOrCreate(['name' => 'super-admin']);
        Role::FirstOrCreate(['name' => 'manager']);
        if (class_exists('\\App\\User')){
            $user = new \App\User();
        }else{
            $user=new \App\Models\User();
        }
        $user->email = $this->ask('Enter Email:', 'admin@example.com');
        $user->name = $this->ask('Enter name:', 'admin');
        $user->password = bcrypt($this->ask('Enter password', 'password'));
        $user->assignRole($role);
        $user->save();
        try {
            $this->info('Admin created. Now login '.route('login'));
        }catch (RouteNotFoundException $exception){
            $this->info('Admin created. Now install Laravel/Ui and login to dashboard.');
        }

        return 0;
    }
}
