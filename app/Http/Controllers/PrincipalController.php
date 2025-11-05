<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PrincipalController extends Controller
{
    /**
     * Show the principal's profile.
     */
    public function profile()
    {
        $principal = Auth::guard('principal')->user();
        return view('principal.dashboard', compact('principal'));
    }

    /**
     * Show form to edit principal profile.
     */
    // public function editProfile()
    // {
    //     $principal = Auth::guard('principal')->user();
    //     return view('principal.edit-profile', compact('principal'));
    // }

    /**
     * Update principal profile.
     */
    // public function updateProfile(Request $request)
    // {
    //     $principal = Auth::guard('principal')->user();

    //     $request->validate([
    //         'name'  => 'required|string|max:255',
    //         'email' => 'required|email|unique:principals,email,' . $principal->id,
    //         'password' => 'nullable|string|min:6|confirmed',
    //     ]);

    //     $principal->name = $request->name;
    //     $principal->email = $request->email;

    //     if ($request->filled('password')) {
    //         $principal->password = Hash::make($request->password);
    //     }

    //     $principal->save();

    //     return redirect()->route('principal.profile')->with('success', 'Profile updated successfully.');
    // }

    /**
     * Delete principal account (optional)
     */
//     public function destroy()
//     {
//         $principal = Auth::guard('principal')->user();
//         Auth::guard('principal')->logout();
//         $principal->delete();

//         return redirect()->route('principal.login')->with('success', 'Account deleted successfully.');
//     }
 }
