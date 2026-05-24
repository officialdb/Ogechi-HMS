<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Seed roles and permissions for the HMS foundation.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = collect(config('hms.permissions', []))
            ->map(fn (string $permission) => Permission::findOrCreate($permission, 'web'));

        $allPermissions = $permissions->pluck('name');

        $rolePermissions = [
            'Super Admin' => $allPermissions,
            'Hospital Admin' => $allPermissions->reject(fn (string $permission) => $permission === 'roles.manage'),
            'Receptionist' => collect([
                'dashboard.view',
                'patients.view',
                'patients.create',
                'patients.update',
                'appointments.view',
                'appointments.create',
                'appointments.update',
                'billing.view',
            ]),
            'Doctor' => collect([
                'dashboard.view',
                'patients.view',
                'doctors.view',
                'appointments.view',
                'appointments.update',
                'laboratory.view',
            ]),
            'Nurse' => collect([
                'dashboard.view',
                'patients.view',
                'appointments.view',
            ]),
            'Lab Scientist' => collect([
                'dashboard.view',
                'laboratory.view',
                'laboratory.manage',
            ]),
            'Pharmacist' => collect([
                'dashboard.view',
                'pharmacy.view',
                'pharmacy.manage',
            ]),
            'Accountant' => collect([
                'dashboard.view',
                'billing.view',
                'billing.manage',
                'reports.view',
            ]),
            'Patient' => collect([
                'dashboard.view',
            ]),
        ];

        foreach (config('hms.roles', []) as $roleName) {
            $role = Role::findOrCreate($roleName, 'web');
            $role->syncPermissions($rolePermissions[$roleName] ?? []);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
