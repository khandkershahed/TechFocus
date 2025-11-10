<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<!-- jQuery Repeater -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 4;

    // Cache DOM elements for better performance
    const $stepperForm = $("#stepperForm");
    const $stepContents = $(".step-content");
    const $nextButtons = $(".next-step");
    const $prevButtons = $(".prev-step");

    // Simple email validation (lighter than full regex)
    $.validator.addMethod("customEmail", function(value, element) {
        return this.optional(element) || 
               (value.indexOf('@') > 0 && value.indexOf('.') > value.indexOf('@') + 1);
    }, "Please enter a valid email address");

    // Simple phone validation
    $.validator.addMethod("customPhone", function(value, element) {
        return this.optional(element) || /^\d{9,15}$/.test(value.replace(/\D/g, ''));
    }, "Please enter a valid phone number (9-15 digits)");

    // Simple ZIP validation
    $.validator.addMethod("customZip", function(value, element) {
        return this.optional(element) || /^\d{4,6}$/.test(value);
    }, "Please enter a valid ZIP code (4-6 digits)");

    // Initialize validation with minimal configuration
    $stepperForm.validate({
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorPlacement: function(error, element) {
            error.addClass("text-danger small");
            element.after(error);
        },
        // Disable some expensive validation features
        onkeyup: false,
        onfocusout: function(element) {
            // Only validate on blur for better performance
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        // Use simpler success handling
        success: function(label) {
            label.remove();
        }
    });

    // Add rules efficiently
    const emailFields = $('input[type="email"]');
    const phoneFields = $('input[name="phone"], input[name="shipping_phone"]');
    const zipFields = $('input[name="zip_code"], input[name="shipping_zip_code"]');

    emailFields.rules("add", { customEmail: true });
    phoneFields.rules("add", { customPhone: true });
    zipFields.rules("add", { customZip: true });

    // Optimized validation checking
    function isStepValid(step) {
        const $step = $(`.step-content[data-step="${step}"]`);
        const $requiredFields = $step.find("[required]");
        let isValid = true;

        // Quick validation without triggering all events
        $requiredFields.each(function() {
            if (!$stepperForm.validate().element(this)) {
                isValid = false;
                return false; // Break loop
            }
        });
        
        return isValid;
    }

    function toggleNextButton() {
        const $currentStep = $(`.step-content[data-step="${currentStep}"]`);
        const $nextBtn = $currentStep.find(".next-step");
        $nextBtn.prop("disabled", !isStepValid(currentStep));
    }

    function toggleStep1Checkboxes() {
        const allValid = isStepValid(1);
        $("#deliveryAddress, #endUser").prop("disabled", !allValid);
    }

    function updateProgress() {
        // Remove all classes first (more efficient than individual removal)
        $(".step").removeClass("active completed current-step-red");
        
        // Add appropriate classes
        $(".step").each(function(index) {
            const stepNum = index + 1;
            const $step = $(this);
            const $icon = $step.find("i");
            
            if (stepNum < currentStep) {
                $step.addClass("completed");
                $icon.show();
            } else if (stepNum === currentStep) {
                $step.addClass("active current-step-red");
                $icon.hide();
            }
        });

        // Update step content visibility
        $stepContents.removeClass("active");
        $(`.step-content[data-step="${currentStep}"]`).addClass("active");

        toggleNextButton();
        if (currentStep === 1) {
            toggleStep1Checkboxes();
        }
    }

    // Debounced input handler for better performance
    let validationTimeout;
    $(document).on("input change", ".step-content.active input, .step-content.active select", function() {
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(() => {
            toggleNextButton();
            if (currentStep === 1) {
                toggleStep1Checkboxes();
            }
        }, 300);
    });

    // Optimized next step handler
    $nextButtons.on("click", function() {
        if (!isStepValid(currentStep)) {
            // Only validate all fields if quick check fails
            $(`.step-content[data-step="${currentStep}"] [required]`).each(function() {
                $stepperForm.validate().element(this);
            });
            return;
        }

        // Handle step navigation logic
        if (currentStep === 1) {
            const deliveryAddress = $("#deliveryAddress").is(":checked");
            const endUser = $("#endUser").is(":checked");

            if (deliveryAddress && endUser) {
                currentStep = 4;
            } else if (deliveryAddress) {
                currentStep = 3;
            } else {
                currentStep = 2;
            }
        } else if (currentStep < totalSteps) {
            currentStep++;
        }
        
        updateProgress();
    });

    // Previous step handler
    $prevButtons.on("click", function() {
        if (currentStep > 1) {
            currentStep--;
            updateProgress();
        }
    });

    // FIXED: Form submission handler
    $stepperForm.on('submit', function(e) {
        e.preventDefault();

        // Quick final validation
        if (!$stepperForm.valid()) {
            // Scroll to first error
            const $firstError = $('.is-invalid').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 100
                }, 500);
            }
            return;
        }

        const form = $(this);
        const formData = new FormData(this);
        const submitBtn = form.find('button[type="submit"]');

        // Debug: Log form data
        console.log('Submitting RFQ form...');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Disable submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

        // Show loading state immediately
        Swal.fire({
            title: 'Submitting RFQ...',
            text: 'Please wait while we process your request',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Use fetch API for better performance with FormData
        fetch(form.attr('action'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            Swal.close();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Your RFQ has been submitted successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else if (data.rfq_code) {
                        window.location.href = '/rfq/' + data.rfq_code;
                    }
                });
            } else {
                throw new Error(data.message || 'Submission failed');
            }
        })
        .catch(error => {
            console.error('Submission error:', error);
            Swal.close();
            
            // FIXED: Use error.message instead of undefined errorMessage variable
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed',
                text: error.message || 'An error occurred while submitting your RFQ. Please try again.',
                confirmButtonText: 'OK'
            });
            
            submitBtn.prop('disabled', false).html('Submit');
        });
    });

    // Reseller checkbox handler
    $("#resellerCheckbox").on("change", function() {
        const $endUserWrapper = $("#endUser").closest(".form-check");
        $endUserWrapper.toggle(!$(this).is(":checked"));
        
        if ($(this).is(":checked")) {
            $("#endUser").prop("checked", false);
        }
        
        toggleNextButton();
        toggleStep1Checkboxes();
    });

    // Step 3 checkbox handler
    $("#stepThreeGotoStep4").on("change", function() {
        if ($(this).is(":checked") && currentStep === 3) {
            currentStep = 4;
            updateProgress();
        }
    });

    // Address copy functionality - optimized
    function setupAddressCopy(sourcePrefix, targetPrefix, checkboxSelector) {
        const fields = ['name', 'email', 'phone', 'company_name', 'designation', 'address', 'country', 'city', 'zip_code'];
        
        $(checkboxSelector).on('change', function() {
            const isChecked = $(this).is(':checked');
            $(checkboxSelector).prop('checked', isChecked);
            
            if (isChecked) {
                fields.forEach(field => {
                    const sourceValue = $(`[name="${sourcePrefix}${field}"]`).val();
                    $(`[name="${targetPrefix}${field}"]`).val(sourceValue);
                });
            }
        });
    }

    // Initialize address copy functionality
    setupAddressCopy('', 'shipping_', '[name="is_contact_address"], .deliveryAddress');
    setupAddressCopy('', 'end_user_', '[name="end_user_is_contact_address"], .endUser');

    // Initial setup
    toggleStep1Checkboxes();
    updateProgress();

    // Quantity increment/decrement functions
    function increment(button) {
        const input = button.closest('.counting-btn').previousElementSibling;
        input.value = Math.max(1, (parseInt(input.value) || 1) + 1);
    }

    function decrement(button) {
        const input = button.closest('.counting-btn').previousElementSibling;
        input.value = Math.max(1, (parseInt(input.value) || 2) - 1);
    }

    // Serial number update for repeater
    function updateSerials() {
        $('[data-repeater-list] [data-repeater-item]').each(function(i) {
            $(this).find('.sl-input').val(i + 1);
        });
    }

    // Initialize repeater with better performance
    $('.repeater').repeater({
        show: function() {
            $(this).slideDown('fast', updateSerials);
        },
        hide: function(deleteElement) {
            const $item = $(this);
            const itemCount = $item.siblings('[data-repeater-item]').length + 1;
            
            if (itemCount > 1) {
                $item.slideUp('fast', function() {
                    deleteElement();
                    updateSerials();
                });
            }
        }
    });
    
    updateSerials();
});
</script>