<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetAdminPassword extends Command
{
    protected $signature = 'app:admin-password {email?} {--password=}';

    protected $description = 'Set (rotate) an admin user password. Generates a strong one if not supplied.';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Admin email', 'admin@nectardigit.com');

        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error("No user with email {$email}.");

            return self::FAILURE;
        }

        $password = $this->option('password') ?: Str::password(16);

        $user->forceFill([
            'password' => bcrypt($password),
            'is_admin' => true,
        ])->save();

        $this->info("Password updated for {$email}.");
        $this->line("New password: {$password}");
        $this->warn('Store it securely — it will not be shown again.');

        return self::SUCCESS;
    }
}
