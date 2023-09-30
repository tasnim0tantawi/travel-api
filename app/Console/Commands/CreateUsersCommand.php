<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to create users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('What is the name of the user?');
        $email = $this->ask('What is the email of the user?');
        $password = $this->secret('What is the password of the user?');
        $roleName = $this->choice('What is the role of the user?', ['admin', 'user'], 1);
        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            $this->error('The role does not exist');
            return;
        }
      
        
       DB::transaction(
           User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]
        )
        ->roles()->attach($role->id)
         );
     
        $this->info('User created successfully');

    }
}
