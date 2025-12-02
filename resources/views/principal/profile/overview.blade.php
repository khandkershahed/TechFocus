@extends('principal.layouts.app')

@section('content')

<div class="py-4 container-fluid">
    <!-- TITLE -->
    <h2 class="mb-4 fw-bold text-dark">Principal Dashboard</h2>
    <!-- =======================
        OVERVIEW CARDS
    ======================== -->
    <div class="mb-4 row g-4">
        <!-- Total Brands -->
        <div class="col-md-6 col-lg-3">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-primary bg-opacity-10 rounded-3 me-3">
                        <i class="fas fa-briefcase text-primary fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Brands</h6>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Principal::count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Active Brands -->
        <div class="col-md-6 col-lg-3">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-success bg-opacity-10 rounded-3 me-3">
                        <i class="fas fa-check-circle text-success fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Active Brands</h6>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Principal::where('status', 1)->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Brands -->
        <div class="col-md-6 col-lg-3">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-warning bg-opacity-10 rounded-3 me-3">
                        <i class="fas fa-clock text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Pending Approvals</h6>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\Principal::where('status', 0)->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="p-3 bg-info bg-opacity-10 rounded-3 me-3">
                        <i class="fas fa-users text-info fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Users</h6>
                        <h3 class="mb-0 fw-bold">{{ \App\Models\User::count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- =======================
        BRAND SUMMARY & QUICK ACTIONS
    ======================== -->
    <div class="mb-4 row g-4">
        <!-- Brand Summary -->
        <div class="col-lg-8">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="pt-4 bg-white border-0 card-header">
                    <h5 class="fw-bold">Brand Summary</h5>
                </div>
                <div class="card-body">

                    @php
                    $brands = \App\Models\Principal::latest()->take(5)->get();
                    @endphp

                    @if($brands->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($brands as $brand)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $brand->name }}</strong><br>
                                <small class="text-muted">Created: {{ $brand->created_at->format('d M, Y') }}</small>
                            </div>

                            @if($brand->status)
                            <span class="px-3 py-2 badge bg-success">Active</span>
                            @else
                            <span class="px-3 py-2 badge bg-warning">Pending</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="mb-0 text-muted">No brand records found.</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="pt-4 bg-white border-0 card-header">
                    <h5 class="fw-bold">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('principal.brands.create') }}" class="mb-2 btn btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Add New Brand
                    </a>
                    <a href="{{ route('principal.brands.index') }}" class="mb-2 btn btn-outline-secondary w-100">
                        <i class="fas fa-list me-2"></i>View All Brands
                    </a>
                    <a href="{{ route('principal.products.create') }}" class="btn btn-outline-dark w-100">
                        <i class="fas fa-edit me-2"></i>Create Brand Content
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- =======================
        ACTIVITY & ANALYTICS
    ======================== -->
    <div class="row g-4">
        <!-- Recent Activity -->
        <div class="col-lg-6">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="pt-4 bg-white border-0 card-header">
                    <h5 class="fw-bold">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check-circle text-success me-3"></i>
                            <div>
                                <strong>Brand Activated</strong>
                                <p class="mb-0 text-muted">Your brand “X Design” was approved.</p>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-user-plus text-primary me-3"></i>
                            <div>
                                <strong>New User Added</strong>
                                <p class="mb-0 text-muted">A new team member joined.</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-pen text-warning me-3"></i>
                            <div>
                                <strong>Brand Updated</strong>
                                <p class="mb-0 text-muted">Logo & details updated for “Creative Hub”.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- System Stats / Progress -->
        <div class="col-lg-6">
            <div class="border-0 shadow-sm card rounded-4 h-100">
                <div class="pt-4 bg-white border-0 card-header">
                    <h5 class="fw-bold">System Overview</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold">Brand Completion</p>
                    <div class="mb-3 progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 76%;"></div>
                    </div>
                    <p class="mb-1 fw-semibold">Profile Status</p>
                    <div class="mb-3 progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 92%;"></div>
                    </div>
                    <p class="mb-1 fw-semibold">Pending Tasks</p>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 45%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection