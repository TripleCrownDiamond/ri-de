<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminUser extends Command
{
    protected $signature = 'admin:update-credentials';
    protected $description = 'Update admin user credentials locally';

    public function handle()
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@remorques-industries.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Azerty%1234#1234'),
                'is_admin' => true,
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $this->info("Admin user updated successfully:");
        $this->info("Email: " . $user->email);
        $this->info("Password: Azerty%1234#1234");
        
        return 0;
    }
}
