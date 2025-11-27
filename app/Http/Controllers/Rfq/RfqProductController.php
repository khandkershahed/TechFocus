<?php

namespace App\Http\Controllers\Rfq;

use Storage;
use App\Models\Rfq;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use Illuminate\Http\Request; 
use App\Models\Admin\Category;
use App\Models\Rfq\RfqProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\RfqProductRequest;

class RfqProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.rfqProduct.index', [
            'rfqProducts' => RfqProduct::with(['rfq', 'product'])->paginate(10), // Added pagination
            'rfqs'        => Rfq::all(),
            'products'    => Product::all(),
            'brands'      => Brand::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.rfqProduct.create', [
            'rfqs'     => Rfq::all(),
            'products' => Product::all(),
            'brands'   => Brand::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RfqProductRequest $request)
    {
        // Calculate prices
        $unitPrice = $request->unit_price;
        $quantity = $request->qty;
        $discount = $request->discount ?? 0;
        $tax = $request->tax ?? 0;
        $vat = $request->vat ?? 0;

        // Calculate totals
        $subTotal = $unitPrice * $quantity;
        $discountAmount = ($subTotal * $discount) / 100;
        $totalAfterDiscount = $subTotal - $discountAmount;
        $taxAmount = ($totalAfterDiscount * $tax) / 100;
        $vatAmount = ($totalAfterDiscount * $vat) / 100;
        $grandTotal = $totalAfterDiscount + $taxAmount + $vatAmount;

        RfqProduct::create([
            'rfq_id'         => $request->rfq_id,
            'product_id'     => $request->product_id,
            'qty'            => $quantity,
            'unit_price'     => $unitPrice,
            'discount'       => $discount,
            'discount_price' => $discountAmount,
            'total_price'    => $subTotal,
            'sub_total'      => $subTotal,
            'tax'            => $tax,
            'tax_price'      => $taxAmount,
            'vat'            => $vat,
            'vat_price'      => $vatAmount,
            'grand_total'    => $grandTotal,
            'product_des'    => $request->product_des,
            'sku_no'         => $request->sku_no,
            'model_no'       => $request->model_no,
            'brand_name'     => $request->brand_name,
        ]);

        return redirect()->route('rfqProducts.index')->with('success', 'RFQ Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rfqProduct = RfqProduct::with(['rfq', 'product'])->findOrFail($id);
        return view('admin.pages.rfqProduct.show', compact('rfqProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rfqProduct = RfqProduct::with(['rfq', 'product'])->findOrFail($id);
        
        return view('admin.pages.rfqProduct.edit', [
            'rfqProduct' => $rfqProduct,
            'rfqs'       => Rfq::all(),
            'products'   => Product::all(),
            'brands'     => Brand::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rfqProduct = RfqProduct::findOrFail($id);

        // Calculate prices
        $unitPrice = $request->unit_price ?? $rfqProduct->unit_price;
        $quantity = $request->qty ?? $rfqProduct->qty;
        $discount = $request->discount ?? $rfqProduct->discount ?? 0;
        $tax = $request->tax ?? $rfqProduct->tax ?? 0;
        $vat = $request->vat ?? $rfqProduct->vat ?? 0;

        // Calculate totals
        $subTotal = $unitPrice * $quantity;
        $discountAmount = ($subTotal * $discount) / 100;
        $totalAfterDiscount = $subTotal - $discountAmount;
        $taxAmount = ($totalAfterDiscount * $tax) / 100;
        $vatAmount = ($totalAfterDiscount * $vat) / 100;
        $grandTotal = $totalAfterDiscount + $taxAmount + $vatAmount;

        $updateData = [
            'rfq_id'         => $request->rfq_id ?? $rfqProduct->rfq_id,
            'product_id'     => $request->product_id ?? $rfqProduct->product_id,
            'qty'            => $quantity,
            'unit_price'     => $unitPrice,
            'discount'       => $discount,
            'discount_price' => $discountAmount,
            'total_price'    => $subTotal,
            'sub_total'      => $subTotal,
            'tax'            => $tax,
            'tax_price'      => $taxAmount,
            'vat'            => $vat,
            'vat_price'      => $vatAmount,
            'grand_total'    => $grandTotal,
            'sku_no'         => $request->sku_no ?? $rfqProduct->sku_no,
            'model_no'       => $request->model_no ?? $rfqProduct->model_no,
            'brand_name'     => $request->brand_name ?? $rfqProduct->brand_name,
            'additional_product_name' => $request->additional_product_name ?? $rfqProduct->additional_product_name,
            'additional_qty' => $request->additional_qty ?? $rfqProduct->additional_qty,
            'product_des'    => $request->product_des ?? $rfqProduct->product_des,
            'additional_info' => $request->additional_info ?? $rfqProduct->additional_info,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($rfqProduct->image) {
                \Storage::disk('public')->delete($rfqProduct->image);
            }
            $path = $request->file('image')->store('rfq_products', 'public');
            $updateData['image'] = $path;
        }

        $rfqProduct->update($updateData);

        return redirect()->route('rfqProducts.index')->with('success', 'RFQ Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rfqProduct = RfqProduct::findOrFail($id);
        
        // Delete image if exists
        if ($rfqProduct->image) {
            Storage::disk('public')->delete($rfqProduct->image);
        }
        
        $rfqProduct->delete();
        
        return redirect()->route('rfqProducts.index')->with('success', 'RFQ Product deleted successfully.');
    }
}