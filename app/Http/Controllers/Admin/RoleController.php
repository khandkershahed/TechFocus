<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.pages.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.pages.role.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,name',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create the role with default 'web' guard
        $role = Role::create([
            'name' => $request->input('role_name'),
            'guard_name' => 'web',
        ]);

        // Assign selected permissions
        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing a role.
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.pages.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update an existing role.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'role_name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $request->input('role_name'),
        ]);

        // Sync permissions
        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        } else {
            // Remove all permissions if none selected
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role updated successfully.');
    }

    /**
     * Delete a role.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role deleted successfully.');
    }
}
