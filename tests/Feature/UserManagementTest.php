<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);
    }

    public function test_super_admin_can_access_user_management()
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');

        $response = $this->actingAs($superAdmin)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function test_non_super_admin_cannot_access_user_management()
    {
        $doctor = User::factory()->create();
        $doctor->assignRole('Doctor');

        $response = $this->actingAs($doctor)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }

    public function test_super_admin_can_update_user_roles()
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');

        $user = User::factory()->create();
        $user->assignRole('Patient');

        $response = $this->actingAs($superAdmin)->put(route('admin.users.roles.update', $user), [
            'roles' => ['Patient', 'Doctor']
        ]);

        $response->assertRedirect(route('admin.users.index'));
        
        $this->assertTrue($user->fresh()->hasRole('Doctor'));
        $this->assertTrue($user->fresh()->hasRole('Patient'));
        $this->assertFalse($user->fresh()->hasRole('Nurse'));
    }

    public function test_super_admin_cannot_accidentally_remove_their_own_super_admin_role()
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');

        $response = $this->actingAs($superAdmin)->put(route('admin.users.roles.update', $superAdmin), [
            'roles' => ['Doctor']
        ]);

        $response->assertRedirect(route('admin.users.index'));
        
        $this->assertTrue($superAdmin->fresh()->hasRole('Super Admin'));
        $this->assertTrue($superAdmin->fresh()->hasRole('Doctor'));
    }
}
