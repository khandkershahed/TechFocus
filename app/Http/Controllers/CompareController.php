<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Product;

class CompareController extends Controller
{
    /**
     * Show all products in comparison session (mini view or page).
     */
    public function index(Request $request)
    {
        $compareIds = $request->session()->get('compare_products', []);
        $products = Product::whereIn('id', $compareIds)->get();

        return view('frontend.pages.product.compare', compact('products'));
    }

    /**
     * Add a product to comparison session
     */
    public function add(Request $request, $id)
    {
        $compare = $request->session()->get('compare_products', []);

        if (!in_array($id, $compare)) {
            $compare[] = $id;
        }

        // Limit to max 4 products
        if (count($compare) > 4) {
            array_shift($compare); // Remove first added if exceeds 4
        }

        $request->session()->put('compare_products', $compare);

        return back()->with('success', 'Product added for comparison!');
    }

    /**
     * Remove a product from comparison session
     */
    public function remove(Request $request, $id)
    {
        $compare = $request->session()->get('compare_products', []);

        if (($key = array_search($id, $compare)) !== false) {
            unset($compare[$key]);
        }

        $request->session()->put('compare_products', $compare);

        return back()->with('success', 'Product removed from comparison!');
    }

    /**
     * Show final comparison page with all selected products
     */
 public function result(Request $request)
{
    $compareIds = $request->session()->get('compare_products', []);
    $products = \App\Models\Admin\Product::with([
        'brand',
        'industries',
        'solutions',
        'multiImages'
    ])->whereIn('id', $compareIds)->get();

    return view('frontend.pages.product.compare-result', compact('products'));
}


    /**
     * Optional: Clear all comparison products
     */
    public function clear(Request $request)
    {
        $request->session()->forget('compare_products');
        return back()->with('success', 'All products removed from comparison.');
    }
}
