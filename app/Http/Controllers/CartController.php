<?php

namespace App\Http\Controllers;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // public function addToCart(Request $request)
    // {
    //     Log::info('Add to cart request received:', $request->all()); // Debug log

    //     try {
    //         // Validate the request
    //         $validator = Validator::make($request->all(), [
    //             'product_id' => 'required|exists:products,id',
    //             'quantity' => 'required|integer|min:1'
    //         ]);

    //         if ($validator->fails()) {
    //             Log::error('Validation failed:', $validator->errors()->toArray());
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Validation failed: ' . $validator->errors()->first()
    //             ], 422);
    //         }

    //         $productId = $request->product_id;
    //         $product = Product::find($productId);

    //         if (!$product) {
    //             Log::error('Product not found:', ['product_id' => $productId]);
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Product not found!'
    //             ], 404);
    //         }

    //         Log::info('Product found:', ['product' => $product->name]); // Debug log

    //         // Get current cart from session
    //         $cart = Session::get('cart', []);
    //         Log::info('Current cart:', $cart); // Debug log

    //         // Check if product already exists in cart
    //         if (isset($cart[$productId])) {
    //             // Update quantity if product exists
    //             $cart[$productId]['quantity'] += $request->quantity;
    //             Log::info('Product quantity updated:', ['product_id' => $productId, 'new_quantity' => $cart[$productId]['quantity']]);
    //         } else {
    //             // Add new product to cart
    //             $cart[$productId] = [
    //                 'product_id' => $product->id,
    //                 'name' => $product->name,
    //                 'price' => $product->sas_price ?? 0,
    //                 'thumbnail' => $product->thumbnail,
    //                 'quantity' => $request->quantity,
    //                 'sku_code' => $product->sku_code,
    //                 'brand' => $product->brand->name ?? 'N/A'
    //             ];
    //             Log::info('New product added to cart:', ['product_id' => $productId]);
    //         }

    //         // Save cart back to session
    //         Session::put('cart', $cart);
    //         Log::info('Cart saved to session:', $cart); // Debug log

    //         // Calculate total items in cart
    //         $cartCount = $this->getCartTotalCount($cart);
    //         Log::info('Cart count calculated:', ['count' => $cartCount]); // Debug log

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Product "' . $product->name . '" added to cart successfully!',
    //             'cart_count' => $cartCount,
    //             'cart' => $cart
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error('Add to cart exception:', [
    //             'message' => $e->getMessage(),
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Server error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function getCartCount()
    // {
    //     try {
    //         $cart = Session::get('cart', []);
    //         $count = $this->getCartTotalCount($cart);
            
    //         return response()->json([
    //             'success' => true,
    //             'count' => $count
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Get cart count error:', ['error' => $e->getMessage()]);
    //         return response()->json([
    //             'success' => false,
    //             'count' => 0
    //         ]);
    //     }
    // }

    // private function getCartTotalCount($cart)
    // {
    //     try {
    //         return array_sum(array_column($cart, 'quantity'));
    //     } catch (\Exception $e) {
    //         Log::error('Get cart total count error:', ['error' => $e->getMessage()]);
    //         return 0;
    //     }
    // }


   // In CartController - addToCart method
// public function addToCart(Request $request)
// {
//     try {
//         $productId = $request->product_id;
//         $quantity = $request->quantity ?? 1;
//         $isRfq = $request->boolean('is_rfq', false);

//         $product = Product::with('brand')->find($productId);
        
//         if (!$product) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Product not found'
//             ], 404);
//         }

//         if ($isRfq) {
//             // Add to RFQ session
//             $rfqItems = session()->get('rfq_items', []);
            
//             $rfqItems[$productId] = [
//                 'id' => $product->id,
//                 'name' => $product->name,
//                 'sku_code' => $product->sku_code,
//                 'product_code' => $product->product_code,
//                 'mf_code' => $product->mf_code,
//                 'brand' => $product->brand->name ?? 'N/A',
//                 'thumbnail' => $product->thumbnail,
//                 'quantity' => $quantity,
//                 'added_at' => now()->timestamp
//             ];
            
//             session()->put('rfq_items', $rfqItems);
            
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Product added to RFQ successfully',
//                 'rfq_count' => count($rfqItems)
//             ]);
//         } else {
//             // Regular cart logic...
//         }

//     } catch (\Exception $e) {
//         Log::error('Add to cart error: ' . $e->getMessage());
//         return response()->json([
//             'success' => false,
//             'message' => 'Server error: ' . $e->getMessage()
//         ], 500);
//     }
// }
public function addToCart(Request $request)
{
    try {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $isRfq = $request->boolean('is_rfq', false);

        $product = Product::with('brand')->find($productId);

        if (!$product) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }
            return back()->with('error', 'Product not found');
        }

        if ($isRfq) {
            // 🟦 RFQ Logic
            $rfqItems = session()->get('rfq_items', []);

            $rfqItems[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku_code' => $product->sku_code,
                'product_code' => $product->product_code,
                'mf_code' => $product->mf_code,
                'brand' => $product->brand->name ?? 'N/A',
                'thumbnail' => $product->thumbnail,
                'quantity' => $quantity,
                'added_at' => now()->timestamp
            ];

            session()->put('rfq_items', $rfqItems);

            // ✅ If request is AJAX, return JSON with redirect link
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to RFQ successfully',
                    'rfq_count' => count($rfqItems),
                    'redirect_url' => route('rfq', ['source' => 'session'])
                ]);
            }

            // ✅ If normal POST (not AJAX), redirect immediately
            return redirect()->route('rfq', ['source' => 'session'])
                ->with('success', 'Product added to RFQ successfully.');
        }

        // 🟩 Regular Cart Logic
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sas_price ?? 0,
                'quantity' => $quantity,
                'thumbnail' => $product->thumbnail,
                'brand' => $product->brand->name ?? 'N/A',
                'added_at' => now()->timestamp
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cart_count' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return back()->with('success', 'Product added to cart successfully.');

    } catch (\Exception $e) {
        Log::error('Add to cart error: ' . $e->getMessage());

        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }

        return back()->with('error', 'Something went wrong. Please try again.');
    }
}

    /**
     * Add product to RFQ session
     */
    private function addToRfqSession(Product $product, $quantity)
    {
        try {
            $rfqItems = Session::get('rfq_items', []);

            // Prepare product data for RFQ session
            $rfqItem = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku_code' => $product->sku_code,
                'mf_code' => $product->mf_code,
                'product_code' => $product->product_code,
                'thumbnail' => $product->thumbnail,
                'sas_price' => $product->sas_price,
                'brand_name' => $product->brand->name ?? '',
                'brand_id' => $product->brand->id ?? null,
                'quantity' => $quantity,
                'short_desc' => $this->cleanDescription($product->short_desc),
                'overview' => $this->cleanDescription($product->overview),
                'added_at' => now()->toDateTimeString()
            ];

            // Add or update in RFQ session
            $rfqItems[$product->id] = $rfqItem;
            Session::put('rfq_items', $rfqItems);

            Log::info('Product added to RFQ session:', $rfqItem);
            Log::info('Total RFQ items in session:', array_keys($rfqItems));

            return response()->json([
                'success' => true,
                'message' => 'Product "' . $product->name . '" added to RFQ successfully!',
                'rfq_count' => count($rfqItems),
                'product' => $rfqItem,
                'is_rfq' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Add to RFQ session exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to RFQ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clean product description
     */
    private function cleanDescription($description)
    {
        if (empty($description)) {
            return '';
        }

        // Remove HTML tags
        $cleanDescription = strip_tags($description);

        // Limit length to prevent issues
        if (strlen($cleanDescription) > 500) {
            $cleanDescription = substr($cleanDescription, 0, 500) . '...';
        }

        return $cleanDescription;
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

    /**
     * Get RFQ session count
     */
    public function getRfqCount()
    {
        try {
            $rfqItems = Session::get('rfq_items', []);
            $count = count($rfqItems);
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Get RFQ count error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }

    /**
     * Get cart contents
     */
    public function getCart()
    {
        try {
            $cart = Session::get('cart', []);
            $rfqItems = Session::get('rfq_items', []);

            return response()->json([
                'success' => true,
                'cart' => array_values($cart),
                'rfq_items' => array_values($rfqItems),
                'cart_count' => $this->getCartTotalCount($cart),
                'rfq_count' => count($rfqItems)
            ]);
        } catch (\Exception $e) {
            Log::error('Get cart error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'cart' => [],
                'rfq_items' => []
            ]);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first()
                ], 422);
            }

            $cart = Session::get('cart', []);
            $productId = $request->product_id;

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $request->quantity;
                Session::put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully',
                    'cart_count' => $this->getCartTotalCount($cart),
                    'cart' => $cart
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Update cart error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {
        try {
            $productId = $request->product_id;
            $cart = Session::get('cart', []);

            if (isset($cart[$productId])) {
                $productName = $cart[$productId]['name'];
                unset($cart[$productId]);
                Session::put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Product "' . $productName . '" removed from cart',
                    'cart_count' => $this->getCartTotalCount($cart),
                    'cart' => $cart
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Remove from cart error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from RFQ session
     */
    public function removeFromRfq(Request $request)
    {
        try {
            $productId = $request->product_id;
            $rfqItems = Session::get('rfq_items', []);

            if (isset($rfqItems[$productId])) {
                $productName = $rfqItems[$productId]['name'];
                unset($rfqItems[$productId]);
                Session::put('rfq_items', $rfqItems);

                return response()->json([
                    'success' => true,
                    'message' => 'Product "' . $productName . '" removed from RFQ',
                    'rfq_count' => count($rfqItems),
                    'rfq_items' => $rfqItems
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in RFQ'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Remove from RFQ error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        try {
            Session::forget('cart');
            
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0
            ]);
        } catch (\Exception $e) {
            Log::error('Clear cart error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear RFQ session
     */
    public function clearRfq()
    {
        try {
            Session::forget('rfq_items');
            
            return response()->json([
                'success' => true,
                'message' => 'RFQ items cleared successfully',
                'rfq_count' => 0
            ]);
        } catch (\Exception $e) {
            Log::error('Clear RFQ error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Debug endpoint to check session state
     */
    public function debug()
    {
        try {
            $cart = Session::get('cart', []);
            $rfqItems = Session::get('rfq_items', []);
            $allSession = Session::all();

            return response()->json([
                'success' => true,
                'session_id' => Session::getId(),
                'cart' => $cart,
                'rfq_items' => $rfqItems,
                'cart_count' => $this->getCartTotalCount($cart),
                'rfq_count' => count($rfqItems),
                'all_session_keys' => array_keys($allSession)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
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