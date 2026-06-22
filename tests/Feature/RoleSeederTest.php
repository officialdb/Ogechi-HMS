<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RoleSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_writer_and_publisher_roles_exist()
    {
        $this->seed(\Database\Seeders\RoleAndPermissionSeeder::class);

        $this->assertDatabaseHas('roles', ['name' => 'Writer']);
        $this->assertDatabaseHas('roles', ['name' => 'Publisher']);

        $writer = Role::findByName('Writer');
        $this->assertTrue($writer->hasPermissionTo('cms.submit'));

        $publisher = Role::findByName('Publisher');
        $this->assertTrue($publisher->hasPermissionTo('cms.approve'));
    }
}
