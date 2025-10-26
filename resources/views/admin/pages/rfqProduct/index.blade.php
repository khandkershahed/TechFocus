@extends('admin.master')

@section('title', 'RFQ Products')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">RFQ Products</h2>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>RFQ Products</h2>
    <a href="{{ route('rfqProducts.create') }}" class="btn btn-primary">+ Add New Product</a>
</div>

    <!-- ✅ RFQ Products Table -->
    <div class="card">
        <div class="card-header">RFQ Product List</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>RFQ ID</th>
                        <th>Product</th>
                        <th>SKU No</th>
                        <th>Model No</th>
                        <th>Brand</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Discount Price</th>
                        <th>Sub Total</th>
                        <th>Tax</th>
                        <th>VAT</th>
                        <th>Grand Total</th>
                        <th>Additional Product</th>
                        <th>Additional Qty</th>
                        <th>Product Description</th>
                        <th>Additional Info</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rfqProducts as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->rfq_id }}</td>
                       <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>{{ $item->sku_no }}</td>
                            <td>{{ $item->model_no }}</td>
                            <td>{{ $item->brand_name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->unit_price }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->discount_price }}</td>
                            <td>{{ $item->sub_total }}</td>
                            <td>{{ $item->tax }}</td>
                            <td>{{ $item->vat }}</td>
                            <td>{{ $item->grand_total }}</td>
                            <td>{{ $item->additional_product_name }}</td>
                            <td>{{ $item->additional_qty }}</td>
                            <td>{{ $item->product_des }}</td>
                            <td>{{ $item->additional_info }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" width="50" height="50" alt="">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm btn-warning mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    Edit
                                    </button>
                                       @if (Auth::guard('admin')->user()->role == 'admin') 

                                <!-- Delete Button -->
                                <form action="{{ route('rfqProducts.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif

                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <form action="{{ route('rfqProducts.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit RFQ Product</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                      <!-- Product Name -->
                                      <div class="col-md-6 mb-3">
                                          <label>Product Name</label>
                                          <input type="text" name="product_name" class="form-control" value="{{ $item->product_name }}">
                                      </div>

                                      <!-- Quantity -->
                                      <div class="col-md-6 mb-3">
                                          <label>Quantity</label>
                                          <input type="number" name="qty" class="form-control" value="{{ $item->qty }}">
                                      </div>

                                      <!-- Unit Price -->
                                      <div class="col-md-6 mb-3">
                                          <label>Unit Price</label>
                                          <input type="number" name="unit_price" class="form-control" value="{{ $item->unit_price }}" step="0.01">
                                      </div>

                                      <!-- Discount -->
                                      <div class="col-md-6 mb-3">
                                          <label>Discount (%)</label>
                                          <input type="number" name="discount" class="form-control" value="{{ $item->discount }}" step="0.01">
                                      </div>

                                      <!-- SKU No -->
                                      <div class="col-md-6 mb-3">
                                          <label>SKU No</label>
                                          <input type="text" name="sku_no" class="form-control" value="{{ $item->sku_no }}">
                                      </div>

                                      <!-- Model No -->
                                      <div class="col-md-6 mb-3">
                                          <label>Model No</label>
                                          <input type="text" name="model_no" class="form-control" value="{{ $item->model_no }}">
                                      </div>

                                      <!-- Brand -->
                                      <div class="col-md-6 mb-3">
                                          <label>Brand</label>
                                          <select name="brand_name" class="form-control">
                                              <option value="">Select Brand</option>
                                              @foreach($brands as $brand)
                                                  <option value="{{ $brand->name }}" {{ $item->brand_name == $brand->name ? 'selected' : '' }}>{{ $brand->name }}</option>
                                              @endforeach
                                          </select>
                                      </div>

                                      <!-- Additional Product -->
                                      <div class="col-md-6 mb-3">
                                          <label>Additional Product Name</label>
                                          <input type="text" name="additional_product_name" class="form-control" value="{{ $item->additional_product_name }}">
                                      </div>

                                      <!-- Additional Qty -->
                                      <div class="col-md-6 mb-3">
                                          <label>Additional Qty</label>
                                          <input type="number" name="additional_qty" class="form-control" value="{{ $item->additional_qty }}">
                                      </div>

                                      <!-- Tax -->
                                      <div class="col-md-6 mb-3">
                                          <label>Tax (%)</label>
                                          <input type="number" name="tax" class="form-control" value="{{ $item->tax }}" step="0.01">
                                      </div>

                                      <!-- VAT -->
                                      <div class="col-md-6 mb-3">
                                          <label>VAT (%)</label>
                                          <input type="number" name="vat" class="form-control" value="{{ $item->vat }}" step="0.01">
                                      </div>

                                      <!-- Image -->
                                      <div class="col-md-6 mb-3">
                                          <label>Image</label>
                                          <input type="file" name="image" class="form-control">
                                          @if($item->image)
                                              <img src="{{ asset('storage/'.$item->image) }}" width="50" height="50" class="mt-2" alt="">
                                          @endif
                                      </div>

                                      <!-- Product Description -->
                                      <div class="col-md-12 mb-3">
                                          <label>Product Description</label>
                                          <textarea name="product_des" class="form-control">{{ $item->product_des }}</textarea>
                                      </div>

                                      <!-- Additional Info -->
                                      <div class="col-md-12 mb-3">
                                          <label>Additional Info</label>
                                          <textarea name="additional_info" class="form-control">{{ $item->additional_info }}</textarea>
                                      </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="20" class="text-center">No RFQ Products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
