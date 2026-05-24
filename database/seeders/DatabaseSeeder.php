<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->call(RoleAndPermissionSeeder::class);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@ogechihospital.test'],
            [
                'name' => 'Ogechi Super Admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->hasRole('Super Admin')) {
            $admin->assignRole('Super Admin');
        }
    }
}
