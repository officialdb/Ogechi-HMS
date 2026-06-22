<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function editRoles(User $user)
    {
        // Exclude Super Admin role from the assignable list to prevent accidental assignment
        // or allow it since only Super Admins can see this page anyway.
        // For now, we will allow all roles, but typically Super Admin shouldn't be reassigned easily.
        $roles = Role::where('name', '!=', 'Super Admin')->get();

        return view('admin.users.roles', compact('user', 'roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $rolesToSync = $request->input('roles', []);

        // Ensure we do not accidentally remove the "Super Admin" role from the current user 
        // if they are modifying their own roles.
        if ($user->hasRole('Super Admin') && !in_array('Super Admin', $rolesToSync)) {
            $rolesToSync[] = 'Super Admin';
        }

        $user->syncRoles($rolesToSync);

        return redirect()->route('admin.users.index')->with('success', 'User roles updated successfully.');
    }
}
