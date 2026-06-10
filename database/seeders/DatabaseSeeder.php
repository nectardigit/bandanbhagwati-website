<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@nectardigit.com');
        $password = env('ADMIN_PASSWORD');

        // Never seed a known/default password. If none is provided, generate a strong
        // random one and print it once so production never ships with "password".
        if (blank($password)) {
            $password = Str::password(16);
            $this->command?->warn("Generated admin password for {$email}: {$password}");
            $this->command?->warn('Store it now — it will not be shown again.');
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => 'Admin', 'password' => bcrypt($password), 'is_admin' => true],
        );

        $this->call(ContentSeeder::class);
    }
}
