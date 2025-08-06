<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::factory()->create([
            'name'              => 'Admin User',
            'username'          => 'admin',
            'email'             => 'admin@portfolio.com',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'status'            => 'active',
            'email_verified_at' => now(),
        ]);

        // Create default test user (if it doesn't exist)
        if (! User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name'              => 'Test User',
                'username'          => 'test',
                'email'             => 'test@example.com',
                'password'          => Hash::make('password'),
                'role'              => 'user',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]);
        }

        // Create some regular users using factory
        User::factory(10)->create();

        // Create some admin users
        User::factory(2)->admin()->create();

        // Create some inactive users
        User::factory(3)->inactive()->create();

        // Create some users with avatars
        User::factory(5)->withAvatar()->create();

        // Create some unverified users
        User::factory(2)->unverified()->create();

        // Create specific users for contact testing
        $contactUsers = [
            [
                'name'     => 'John Smith',
                'username' => 'johnsmith',
                'email'    => 'john.smith@example.com',
                'role'     => 'user',
                'status'   => 'active',
            ],
            [
                'name'     => 'Sarah Johnson',
                'username' => 'sarahjohnson',
                'email'    => 'sarah.johnson@company.com',
                'role'     => 'user',
                'status'   => 'active',
            ],
            [
                'name'     => 'Emily Rodriguez',
                'username' => 'emilyrodriguez',
                'email'    => 'emily.r@designstudio.com',
                'role'     => 'user',
                'status'   => 'active',
            ],
        ];

        foreach ($contactUsers as $userData) {
            if (! User::where('email', $userData['email'])->exists()) {
                User::factory()->create([
                    'name'              => $userData['name'],
                    'username'          => $userData['username'],
                    'email'             => $userData['email'],
                    'password'          => Hash::make('password'),
                    'role'              => $userData['role'],
                    'status'            => $userData['status'],
                    'email_verified_at' => now(),
                ]);
            }
        }
    }
}
