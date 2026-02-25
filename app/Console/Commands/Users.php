<?php

/**
 * @author <mdadalkhan@gmail.com>
 * @created_at: 23/02/2026
 * @updated-at: 23/02/2026
 * */


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Command
{
    protected $signature = 'cmd:users {action} {email} {password?} {name?} {--admin}';
    protected $description = 'Users Managements';

    public function handle()
    {
        $action   = $this->argument('action');
        $email    = $this->argument('email');
        $password = $this->argument('password');
        $name     = $this->argument('name');
        $isAdmin  = $this->option('admin');

        switch ($action) {
            case 'create':
                if (!$password) {
                    $this->error("Password is required for creation.");
                    return Command::FAILURE;
                }

                $user = User::create([
                    'name'     => $name ?? 'New User',
                    'email'    => $email,
                    'password' => Hash::make($password)
                ]);

                $this->info("User {$email} created.");
                break;

            case 'update':
                if (!$password) {
                    $this->error("New password is required for update.");
                    return Command::FAILURE;
                }

                $user = User::where('email', $email)->first();

                if (!$user) {
                    $this->error("User not found.");
                    return Command::FAILURE;
                }

                $user->update(['password' => Hash::make($password)]);
                $this->info("Password updated for {$email}.");
                break;

            case 'delete':
                $user = User::where('email', $email)->first();

                if (!$user) {
                    $this->error("User not found.");
                    return Command::FAILURE;
                }

                $user->delete();
                $this->info("User {$email} deleted.");
                break;

            default:
                $this->error("Invalid action. Use create, update, or delete.");
                return Command::FAILURE;
        }

        if ($isAdmin) {
            $this->warn('Admin flag detected.');
        }

        return Command::SUCCESS;
    }
}