<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->where('guard_name', 'admin')->get(); // Fixed: role -> roles
        return view('admin.pages.role.index', compact('roles')); // Fixed: role -> roles
    }

    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.pages.role.form', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name', // Fixed: role -> roles
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        if ($request->has('permissions')) {
            // Get permission names from IDs
            $permissionNames = Permission::whereIn('id', $request->permissions)
                                        ->where('guard_name', 'admin')
                                        ->pluck('name')
                                        ->toArray();
            
            $role->syncPermissions($permissionNames);
        }

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::where('guard_name', 'admin')->get();
        
        return view('admin.pages.role.form', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id, // Fixed: role -> roles
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            // Get permission names from IDs
            $permissionNames = Permission::whereIn('id', $request->permissions)
                                        ->where('guard_name', 'admin')
                                        ->pluck('name')
                                        ->toArray();
            
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deletion of SuperAdmin role
        if ($role->name === 'SuperAdmin') {
            return redirect()->back()->with('error', 'Cannot delete SuperAdmin role.');
        }

        $role->delete();

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role deleted successfully.');
    }
}