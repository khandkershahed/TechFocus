<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = Admin::with('roles')->get(); 
        return view('admin.pages.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get(); 
        return view('admin.pages.user.create', compact('roles'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:admins,email',
    //         'password' => 'required|string|min:8|confirmed',
    //         'roles' => 'required|array',
    //         'roles.*' => 'exists:roles,id'
    //     ]);

    //     $user = Admin::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'email_verified_at' => now(),
    //     ]);

    //     $user->syncRoles($request->roles);

    //     return redirect()->route('admin.users.index')
    //                      ->with('success', 'User created successfully.');
    // }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'password' => 'required|string|min:8|confirmed',
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id'
    ]);

    $user = Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_verified_at' => now(),
    ]);

    // FIX: Convert role IDs to role names
    $roleNames = Role::whereIn('id', $request->roles)
                    ->where('guard_name', 'admin')
                    ->pluck('name')
                    ->toArray();

    $user->syncRoles($roleNames);

    return redirect()->route('admin.users.index')
                     ->with('success', 'User created successfully.');
}

public function update(Request $request, $id)
{
    $user = Admin::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,id'
    ]);

    $updateData = [
        'name' => $request->name,
        'email' => $request->email,
    ];

    // Update password only if provided
    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }

    $user->update($updateData);

    // FIX: Convert role IDs to role names
    $roleNames = Role::whereIn('id', $request->roles)
                    ->where('guard_name', 'admin')
                    ->pluck('name')
                    ->toArray();

    $user->syncRoles($roleNames);

    return redirect()->route('admin.users.index')
                     ->with('success', 'User updated successfully.');
}

    // ADD THIS MISSING EDIT METHOD
    public function edit($id)
    {
        $user = Admin::with('roles')->findOrFail($id);
        $roles = Role::where('guard_name', 'admin')->get();
        
        return view('admin.pages.user.edit', compact('user', 'roles'));
    }

    // // ADD THIS UPDATE METHOD
    // public function update(Request $request, $id)
    // {
    //     $user = Admin::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:admins,email,' . $user->id,
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'roles' => 'required|array',
    //         'roles.*' => 'exists:roles,id'
    //     ]);

    //     $updateData = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //     ];

    //     // Update password only if provided
    //     if ($request->filled('password')) {
    //         $updateData['password'] = Hash::make($request->password);
    //     }

    //     $user->update($updateData);

    //     // Sync roles
    //     $user->syncRoles($request->roles);

    //     return redirect()->route('admin.users.index')
    //                      ->with('success', 'User updated successfully.');
    // }

    // ADD THIS DESTROY METHOD
    public function destroy($id)
    {
        $user = Admin::findOrFail($id);
        
        // Prevent deletion of current logged in admin
        if ($user->id === auth('admin')->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}