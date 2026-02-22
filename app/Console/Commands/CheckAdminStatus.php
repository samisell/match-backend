<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CheckAdminStatus extends Command
{
    protected $signature = 'app:check-admin-status {email} {password}';
    protected $description = 'Check if a user is an admin and if the password is correct';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return;
        }

        $this->info("User found: {$user->name} ({$user->email})");

        if (Hash::check($password, $user->password)) {
            $this->info("Password is correct.");
        } else {
            $this->error("Password does not match.");
        }

        if ($user->is_admin) {
            $this->info("User is an administrator.");
        } else {
            $this->error("User is NOT an administrator.");
        }
    }
}