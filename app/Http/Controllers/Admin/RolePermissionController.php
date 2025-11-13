<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function show($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $permissions = Permission::all();

        return view('admin.pages.rolePermission.show', compact('role', 'permissions'));
    }

    public function assignPermission(Request $request, $roleId)
    {
        $request->validate([
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($roleId);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        } else {
            $role->syncPermissions([]); // remove all if none selected
        }

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
