<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use App\Models\Country;
use App\Models\Admin\Category;
use App\Models\Solution;
use App\Models\Admin\AdminScope;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AdminScopeController extends Controller
{
    public function edit($roleId)
    {
        $role = Role::with('adminScopes')->findOrFail($roleId);
        
        // Get available scopes (you'll need to adjust these based on your models)
        $brands = Brand::all();
        $categories = Category::all();
        $solutions = Solution::all();
        $countries = Country::all();

        return view('admin.pages.role.scopes', compact(
            'role', 'brands', 'categories', 'solutions', 'countries'
        ));
    }

    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        
        $validated = $request->validate([
            'scopes.brand' => 'array|nullable',
            'scopes.category' => 'array|nullable',
            'scopes.solution' => 'array|nullable',
            'scopes.country' => 'array|nullable',
        ]);

        $role->syncScopes($validated['scopes'] ?? []);

        return redirect()->back()->with('success', 'Admin scopes updated successfully.');
    }
}
