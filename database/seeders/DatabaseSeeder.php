<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== Create Default Roles =====
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'customer']);

        // ===== Create Default Admin User =====
        $admin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'], // check by email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'), // default password
            ]
        );

        // ===== Assign Admin Role =====
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Optional: Example Customer User
        // $customer = User::firstOrCreate(
        //     ['email' => 'customer@subpilot.com'],
        //     [
        //         'name' => 'Demo Customer',
        //         'password' => Hash::make('password'),
        //     ]
        // );
        // $customer->assignRole('customer');

        $this->command->info('✅ Roles and Admin User seeded successfully.');
    }
}
