<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.pages.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'string',
        ]);

        $createdPermissions = [];

        // Create multiple permissions
        foreach ($request->permissions as $permissionName) {
            if (!Permission::where('name', $permissionName)->where('guard_name', 'admin')->exists()) {
                $permission = Permission::create([
                    'name' => $permissionName,
                    'guard_name' => 'admin'
                ]);
                $createdPermissions[] = $permission->name;
            }
        }

        $message = count($createdPermissions) > 0 
            ? 'Permissions created successfully: ' . implode(', ', $createdPermissions)
            : 'No new permissions were created (they may already exist).';

        return redirect()->route('admin.permissions.index')
                         ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id); // FIXED: Added this line
        return view('admin.pages.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        return redirect()->route('admin.permissions.index')
                         ->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('admin.permissions.index')
                         ->with('success', 'Permission deleted successfully.');
    }
}