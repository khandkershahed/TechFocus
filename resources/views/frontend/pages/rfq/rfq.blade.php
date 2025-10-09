@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container mm">
    <!-- Header Section -->
    <div class="row align-items-center">
        <div class="my-5 col-lg-12 text-center">
            <h2 class="mb-1 titles font-two">RECEIVE AND <span class="main-color">COMPARE</span></h2>
            <h2 class="titles font-two"><span class="main-color">QUOTATIONS</span> FOR FREE</h2>
            <p class="pt-2">Take advantage of our supplier network to complete your purchasing projects.</p>
        </div>
    </div>

    <!-- Steps Icons -->
    <div class="mb-5 row">
        @foreach(['DESCRIBE YOUR PURCHASE PROJECT', 'FILL PROJECT DETAILS', 'SUBMIT RFQ'] as $i => $step)
        <div class="col-lg-4">
            <div class="d-flex flex-column align-items-center">
                <img class="rfq-img rounded-circle mb-2" 
                     src="https://img.directindustry.com/media/ps/images/common/rfq/ao-step-0{{ $i+1 }}.svg" 
                     alt="">
                <p class="font-three text-center">{{ $step }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Form Section -->
    <div class="row gx-5">
        <div class="col-lg-12">
            <div class="devider-wrap">
                <h4 class="mb-4 devider-content"><span class="devider-text">SUBMIT YOUR REQUEST FOR QUOTATION</span></h4>
            </div>
        </div>
    </div>

    <form action="{{ route('rfq.store') }}" method="POST" class="card shadow-sm border-0 rfq-form">
        @csrf
        <!-- Nav Pills -->
        <div class="card-header p-0" style="background-color: var(--secondary-color)">
            <nav class="nav nav-pills nav-fill">
                @foreach(['Your Needs', 'Project Details', 'Company Details', 'Finish'] as $i => $tab)
                    <a class="nav-link tab-pills rounded-0 @if($i==0) active @endif" data-tab="{{ $i }}" href="#">
                        {{ $tab }}
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="card-body">
            <!-- Tab 0: Your Needs -->
            <div class="tab active" data-tab="0">
                <p class="font-three">Do you need detailed and personalized quotes for a specific project?</p>
                <div class="my-4 row align-items-center">
                    <div class="col-lg-2">
                        <label for="conceptTermId">YOUR SELECTION <span>*</span></label>
                    </div>
                    <div class="col-lg-10">
                        <select id="conceptTermId" name="conceptTermId" class="form-select rounded-0" required>
                            <option value="">Choose an option</option>
                            <option value="software">Software</option>
                            <option value="hardware">Hardware</option>
                            <option value="product">Product</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tab 1: Project Details -->
            <div class="tab d-none" data-tab="1">
                <p class="mb-2 text-danger font-two">Describe your project in detail (min 300 characters)</p>
                <textarea class="form-control rounded-0" name="info" rows="8" placeholder="Enter project details..." required></textarea>
                <div class="mt-3 row">
                    <div class="col-lg-3">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" class="form-control rounded-0" required>
                    </div>
                    <div class="col-lg-3">
                        <label>Budget (min €5,000) <span class="text-danger">*</span></label>
                        <select name="budget" class="form-select rounded-0" required>
                            <option value="">Choose budget</option>
                            <option value="5000">€5,000</option>
                            <option value="6000">€6,000</option>
                            <option value="7000">€7,000</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Delivery City <span class="text-danger">*</span></label>
                        <input type="text" name="delivery_city" class="form-control rounded-0" required>
                    </div>
                    <div class="col-lg-3">
                        <label>Decision Period <span class="text-danger">*</span></label>
                        <input type="number" name="decision_period" class="form-control rounded-0" required>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Company Details -->
            <div class="tab d-none" data-tab="2">
                <div class="row">
                    <div class="col-lg-6">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-0" required>

                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control rounded-0" required>

                        <label>City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control rounded-0" required>
                    </div>
                    <div class="col-lg-6">
                        <label>Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" class="form-control rounded-0" required>

                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control rounded-0" required>

                        <label>Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control rounded-0" required>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Finish -->
            <div class="tab d-none text-center" data-tab="3">
                <p class="mb-4">Thank you for considering our service. Your request is important to us.</p>
                <img src="https://i.ibb.co/27nsMpC/7efs.gif" width="220px" class="mb-3">
                <p>Please press the <span class="main-color">Submit</span> button below.</p>
                <button type="submit" class="btn btn-primary">Submit RFQ</button>
            </div>
        </div>

        <!-- Form Navigation -->
        <div class="card-footer d-flex justify-content-between">
            <button type="button" id="back_button" class="btn btn-outline-secondary" onclick="previousTab()">Back</button>
            <button type="button" id="next_button" class="btn btn-primary" onclick="nextTab()">Next</button>
        </div>
    </form>
</div>

<script>
let currentTab = 0;
const tabs = document.querySelectorAll('.tab');
const totalTabs = tabs.length;

function showTab(n) {
    tabs.forEach(tab => tab.classList.add('d-none'));
    tabs[n].classList.remove('d-none');

    document.querySelectorAll('.tab-pills').forEach((tab, i) => {
        tab.classList.toggle('active', i === n);
    });

    document.getElementById('back_button').style.display = n === 0 ? 'none' : 'inline-block';
    document.getElementById('next_button').style.display = n === totalTabs-1 ? 'none' : 'inline-block';
}

function nextTab() {
    if (validateCurrentTab() && currentTab < totalTabs-1) {
        currentTab++;
        showTab(currentTab);
    }
}

function previousTab() {
    if (currentTab > 0) {
        currentTab--;
        showTab(currentTab);
    }
}

function validateCurrentTab() {
    const inputs = tabs[currentTab].querySelectorAll('input, select, textarea');
    for (let input of inputs) {
        if (input.required && !input.value.trim()) {
            input.classList.add('is-invalid');
            input.focus();
            return false;
        }
        if (input.name === 'info' && input.value.trim().length < 300) {
            alert('Please provide at least 300 characters for project description.');
            input.focus();
            return false;
        }
        input.classList.remove('is-invalid');
    }
    return true;
}

// Nav pills click
document.querySelectorAll('.tab-pills').forEach((pill, index) => {
    pill.addEventListener('click', e => {
        e.preventDefault();
        if (index <= currentTab || validateCurrentTab()) {
            currentTab = index;
            showTab(currentTab);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => showTab(currentTab));
</script>

<style>
.is-invalid { border-color: #dc3545 !important; }
.tab-pills { cursor:pointer; transition:0.3s; }
.tab-pills:hover { background-color: rgba(0,0,0,0.1); }
.nav-link.active { background-color: var(--main-color) !important; color:white !important; }
</style>
@endsection
