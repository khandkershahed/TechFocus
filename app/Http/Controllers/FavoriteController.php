<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display user's favorites
     */
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('frontend.pages.client.favourites', compact('favorites'));
    }

    /**
     * Add a product to favorites.
     * If not logged in, redirect to a choice page for login.
     */
    public function store(Request $request, $productId)
    {
        if (!Auth::check()) {
            // Redirect to a page where user can choose to log in as client or partner
            return redirect()->route('login-choice', [
                'redirect_to' => url()->current(),
                'product_id'  => $productId
            ])->with('error', 'Please log in to add favorites.');
        }

        // Add favorite if it doesn't exist
        Favorite::firstOrCreate([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Product added to favorites!');
    }

    /**
     * Remove a product from favorites
     */
    public function destroy($productId)
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'Removed from favorites.');
    }
}
