<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Show Client Dashboard
     */
        public function dashboard()
    {
        // Pass authenticated user to the dashboard view
        $user = Auth::user();

        return view('frontend.pages.client.dashboard', compact('user'));
    }

    /**
     * Show Client Profile Page
     */
    public function profile()
    {
        $this->authorizeClient();
        $user = Auth::user();
        return view('frontend.pages.client.profile', compact('user'));
    }

    public function subscription()
    {
        $this->authorizeClient();
        return view('frontend.pages.client.subscription');
    }

    public function favourites()
    {
        $this->authorizeClient();
        return view('frontend.pages.client.favourites');
    }

    public function requests()
    {
        $this->authorizeClient();
        return view('frontend.pages.client.requests');
    }

    /**
     * Check if authenticated user is a client
     */
    private function authorizeClient()
    {
        if (!Auth::check() || Auth::user()->user_type !== 'client') {
            abort(403, 'Unauthorized access.');
        }
    }
}
