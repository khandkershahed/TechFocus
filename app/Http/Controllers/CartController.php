<?php

namespace App\Http\Controllers;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        Log::info('Add to cart request received:', $request->all()); // Debug log

        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first()
                ], 422);
            }

            $productId = $request->product_id;
            $product = Product::find($productId);

            if (!$product) {
                Log::error('Product not found:', ['product_id' => $productId]);
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found!'
                ], 404);
            }

            Log::info('Product found:', ['product' => $product->name]); // Debug log

            // Get current cart from session
            $cart = Session::get('cart', []);
            Log::info('Current cart:', $cart); // Debug log

            // Check if product already exists in cart
            if (isset($cart[$productId])) {
                // Update quantity if product exists
                $cart[$productId]['quantity'] += $request->quantity;
                Log::info('Product quantity updated:', ['product_id' => $productId, 'new_quantity' => $cart[$productId]['quantity']]);
            } else {
                // Add new product to cart
                $cart[$productId] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->sas_price ?? 0,
                    'thumbnail' => $product->thumbnail,
                    'quantity' => $request->quantity,
                    'sku_code' => $product->sku_code,
                    'brand' => $product->brand->name ?? 'N/A'
                ];
                Log::info('New product added to cart:', ['product_id' => $productId]);
            }

            // Save cart back to session
            Session::put('cart', $cart);
            Log::info('Cart saved to session:', $cart); // Debug log

            // Calculate total items in cart
            $cartCount = $this->getCartTotalCount($cart);
            Log::info('Cart count calculated:', ['count' => $cartCount]); // Debug log

            return response()->json([
                'success' => true,
                'message' => 'Product "' . $product->name . '" added to cart successfully!',
                'cart_count' => $cartCount,
                'cart' => $cart
            ]);

        } catch (\Exception $e) {
            Log::error('Add to cart exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCartCount()
    {
        try {
            $cart = Session::get('cart', []);
            $count = $this->getCartTotalCount($cart);
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Get cart count error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }

    private function getCartTotalCount($cart)
    {
        try {
            return array_sum(array_column($cart, 'quantity'));
        } catch (\Exception $e) {
            Log::error('Get cart total count error:', ['error' => $e->getMessage()]);
            return 0;
        }
    }
}