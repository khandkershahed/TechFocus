@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container mm">
    <div class="row align-items-center">
        <div class="my-5 col-lg-12">
            <h2 class="mb-1 text-center titles font-two">
                RECEIVE AND <span class="main-color"> COMPARE </span>
            </h2>
            <h2 class="text-center titles font-two">
                <span class="main-color">QUOTATIONS</span> FOR FREE
            </h2>
            <p class="pt-2 text-center">
                Take advantage of our supplier network to complete your purchasing projects.
            </p>
        </div>
    </div>

    <!-- Display Success/Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container mb-5">
        <form class="card rounded-0 border-0 shadow-sm rfq-img" 
              action="{{ route('rfq.store') }}" 
              method="POST" id="rfqForm">
            @csrf
            <div class="p-0 m-0 border-0 card-header rounded-0" style="background-color: var(--secondary-color)">
                <nav class="nav nav-pills nav-fill">
                    <a class="p-3 nav-link tab-pills step-form-btn rounded-0 active" data-tab="0">Your Needs</a>
                    <a class="p-3 nav-link tab-pills step-form-btn rounded-0" data-tab="1">Address Details</a>
                    <a class="p-3 nav-link tab-pills step-form-btn rounded-0" data-tab="2">Company Details</a>
                    <a class="p-3 nav-link tab-pills step-form-btn rounded-0" data-tab="3">Finish</a>
                </nav>
            </div>

            <div class="card-body">
                <!-- First Tab -->
                <div class="tab active" data-tab="0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="d-flex">
                                <div class="mt-2 me-2">
                                    <i class="fa-solid fa-circle-info text-muted" style="font-size: 30px"></i>
                                </div>
                                <div>
                                    <p class="pt-0 pb-2 m-2 font-three">
                                        Do you need detailed and personalized quotes for a specific project?
                                    </p>
                                    <p class="m-2 font-three">
                                        ➔ Looking for one product? Fill out our Request for Quotation (RFQ) form and get custom offers within 48 hours!
                                    </p>
                                    <p class="m-2 font-three">
                                        ➔ Looking for several products? Submit as many Requests for Quotation (RFQs) as products requested (one request per product).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-5 row align-items-center">
                        <div class="col-lg-2">
                            <label for="selection" class="wrapper">YOUR SELECTION <span>*</span></label>
                        </div>
                        <div class="col-lg-10">
                            <select id="selection" class="form-select rounded-0" name="conceptTermId" required>
                                <option value="">Choose an option</option>
                                <option value="software">Software</option>
                                <option value="hardware">Hardware</option>
                                <option value="product">Product</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Second Tab -->
                <div class="tab d-none" data-tab="1">
                    <p class="mb-2 text-danger font-two">
                        Describe your project in detail (at least 300 characters)
                    </p>
                    <textarea class="border form-control rounded-0" name="info" rows="10" placeholder="Enter project details..." required></textarea>

                    <div class="mt-3 row">
                        <div class="col-lg-3 col-sm-12">
                            <label>Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control rounded-0" name="quantity" placeholder="Enter Quantity" required>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Budget (minimum €5,000) <span class="text-danger">*</span></label>
                            <select class="form-select rounded-0" name="budget" required>
                                <option value="">Choose a budget</option>
                                <option value="5000">€5,000</option>
                                <option value="6000">€6,000</option>
                                <option value="7000">€7,000</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Delivery city <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" name="delivery_city" placeholder="Enter City" required>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <label>Decision period <span class="text-danger">*</span></label>
                            <input type="number" class="form-control rounded-0" name="decision_period" placeholder="Enter Decision Period" required>
                        </div>
                    </div>
                </div>

                <!-- Third Tab -->
                <div class="tab d-none" data-tab="2">
                    <div class="mt-3 row">
                        <div class="col-lg-6 col-sm-12">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded-0" name="email" placeholder="Enter Email" required>

                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" name="last_name" placeholder="Enter Last Name" required>

                            <label>City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" name="city" placeholder="Enter City" required>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" name="company_name" placeholder="Enter Company Name" required>

                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" name="first_name" placeholder="Enter First Name" required>

                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-0" name="phone" placeholder="Enter Phone Number" required>
                        </div>
                    </div>
                </div>

                <!-- Fourth Tab -->
                <div class="tab d-none text-center" data-tab="3">
                    <p>Thank you for considering our service. Your request is important to us.</p>
                    <button type="submit" class="btn signin rounded-0">Submit Now</button>
                </div>
            </div>

            <!-- Navigation -->
            <div class="card-footer text-end">
                <button type="button" id="back_button" class="btn common-btn-4 rounded-0" onclick="previousTab()">Back</button>
                <button type="button" id="next_button" class="btn signin ms-auto rounded-0" onclick="nextTab()">Next</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentTab = 0;
const tabs = document.querySelectorAll('.tab');
const totalTabs = tabs.length;

// Initialize the form
document.addEventListener('DOMContentLoaded', function() {
    showTab(currentTab);
});

function showTab(n) {
    // Hide all tabs
    tabs.forEach(tab => {
        tab.classList.add('d-none');
        tab.classList.remove('active');
    });
    
    // Show current tab
    tabs[n].classList.remove('d-none');
    tabs[n].classList.add('active');
    
    // Update navigation pills
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach((link, index) => {
        if (index === n) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
    
    // Update buttons
    updateButtons(n);
}

function updateButtons(n) {
    const backButton = document.getElementById('back_button');
    const nextButton = document.getElementById('next_button');
    
    if (n === 0) {
        // First tab
        backButton.style.display = 'none';
        nextButton.innerHTML = 'Next';
    } else if (n === totalTabs - 1) {
        // Last tab
        backButton.style.display = 'inline-block';
        nextButton.style.display = 'none';
    } else {
        // Middle tabs
        backButton.style.display = 'inline-block';
        nextButton.style.display = 'inline-block';
        nextButton.innerHTML = 'Next';
    }
}

function nextTab() {
    if (currentTab < totalTabs - 1) {
        // Validate current tab before proceeding
        if (validateCurrentTab()) {
            currentTab++;
            showTab(currentTab);
        }
    }
}

function previousTab() {
    if (currentTab > 0) {
        currentTab--;
        showTab(currentTab);
    }
}

function validateCurrentTab() {
    const currentTabElement = tabs[currentTab];
    const inputs = currentTabElement.querySelectorAll('input, select, textarea');
    let isValid = true;
    
    // Remove previous error styles
    inputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    // Validate required fields
    for (let input of inputs) {
        if (input.hasAttribute('required')) {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
                
                // Focus on first invalid field
                if (isValid === false) {
                    input.focus();
                    break;
                }
            }
            
            // Special validation for textarea
            if (input.name === 'info' && input.value.trim().length < 300) {
                input.classList.add('is-invalid');
                isValid = false;
                alert('Please provide at least 300 characters for project description.');
                input.focus();
                break;
            }
        }
    }
    
    return isValid;
}

// Add click event to nav links for better UX
document.querySelectorAll('.nav-link[data-tab]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetTab = parseInt(this.getAttribute('data-tab'));
        
        // Only allow navigation to previous tabs or validated current tab
        if (targetTab <= currentTab || (targetTab > currentTab && validateCurrentTab())) {
            currentTab = targetTab;
            showTab(currentTab);
        }
    });
});
</script>

<style>
.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.nav-link.active {
    background-color: var(--main-color) !important;
    color: white !important;
}

.tab-pills {
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-pills:hover {
    background-color: rgba(0,0,0,0.1) !important;
}
</style>
@endsection