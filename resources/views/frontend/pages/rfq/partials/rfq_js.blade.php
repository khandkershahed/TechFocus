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

    // Cache DOM elements
    const $stepperForm = $("#stepperForm");
    const $stepContents = $(".step-content");
    const $nextButtons = $(".next-step");
    const $prevButtons = $(".prev-step");

    // Email validation
    $.validator.addMethod("customEmail", function(value, element) {
        return this.optional(element) ||
               (value.indexOf('@') > 0 && value.indexOf('.') > value.indexOf('@') + 1);
    }, "Please enter a valid email address");

    // Phone
    $.validator.addMethod("customPhone", function(value, element) {
        return this.optional(element) || /^\d{9,15}$/.test(value.replace(/\D/g, ''));
    }, "Please enter a valid phone number (9-15 digits)");

    // ZIP
    $.validator.addMethod("customZip", function(value, element) {
        return this.optional(element) || /^\d{4,6}$/.test(value);
    }, "Please enter a valid ZIP code (4-6 digits)");

    // Initialize validation
    $stepperForm.validate({
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorPlacement: function(error, element) {
            error.addClass("text-danger small");
            element.after(error);
        },
        onkeyup: false,
        onfocusout: function(element) {
            if (!this.checkable(element)) {
                this.element(element);
            }
        },
        success: function(label) {
            label.remove();
        }
    });

    // Add rules
    $('input[type="email"]').rules("add", { customEmail: true });
    $('input[name="phone"], input[name="shipping_phone"]').rules("add", { customPhone: true });
    $('input[name="zip_code"], input[name="shipping_zip_code"]').rules("add", { customZip: true });

    function isStepValid(step) {
        const $step = $(`.step-content[data-step="${step}"]`);
        let valid = true;

        $step.find("[required]").each(function() {
            if (!$stepperForm.validate().element(this)) {
                valid = false;
                return false;
            }
        });

        return valid;
    }

    function toggleNextButton() {
        const $current = $(`.step-content[data-step="${currentStep}"]`);
        $current.find(".next-step").prop("disabled", !isStepValid(currentStep));
    }

    function toggleStep1Checkboxes() {
        $("#deliveryAddress, #endUser").prop("disabled", !isStepValid(1));
    }

    function updateProgress() {
        $(".step").removeClass("active completed current-step-red");

        $(".step").each(function(i) {
            const stepNum = i + 1;
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

        $stepContents.removeClass("active");
        $(`.step-content[data-step="${currentStep}"]`).addClass("active");

        toggleNextButton();
        if (currentStep === 1) toggleStep1Checkboxes();
    }

    // Input validation debounce
    let validationTimeout;
    $(document).on("input change", ".step-content.active input, .step-content.active select", function() {
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(() => {
            toggleNextButton();
            if (currentStep === 1) toggleStep1Checkboxes();
        }, 300);
    });

    // Next button
    $nextButtons.on("click", function() {
        if (!isStepValid(currentStep)) {
            $(`.step-content[data-step="${currentStep}"] [required]`).each(function() {
                $stepperForm.validate().element(this);
            });
            return;
        }

        if (currentStep === 1) {
            const deliveryAddress = $("#deliveryAddress").is(":checked");
            const endUser = $("#endUser").is(":checked");

            if (deliveryAddress && endUser) currentStep = 4;
            else if (deliveryAddress) currentStep = 3;
            else currentStep = 2;
        } else if (currentStep < totalSteps) {
            currentStep++;
        }

        updateProgress();
    });

    // Prev button
    $prevButtons.on("click", function() {
        if (currentStep > 1) {
            currentStep--;
            updateProgress();
        }
    });

    // ✅ FORM SUBMISSION WITH SESSION CLEARING
    $stepperForm.on('submit', function(e) {
        e.preventDefault();

        if (!$stepperForm.valid()) {
            $('html, body').animate({ scrollTop: $('.is-invalid').first().offset().top - 100 }, 500);
            return;
        }

        const form = $(this);
        const formData = new FormData(this);
        const submitBtn = form.find('button[type="submit"]');

        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

        Swal.fire({
            title: 'Submitting RFQ...',
            text: 'Please wait while we process your request',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch(form.attr('action'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();

            if (data.success) {

                // ✅✅ CLEAR RFQ + CART SESSION
                fetch("/destroy-after-rfq", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Your RFQ has been submitted successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data.redirect_url) window.location.href = data.redirect_url;
                    else if (data.rfq_code) window.location.href = "/rfq/" + data.rfq_code;
                });
            } else {
                throw new Error(data.message || 'Submission failed');
            }
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed',
                text: error.message || 'An error occurred. Please try again.'
            });
            submitBtn.prop('disabled', false).html('Submit');
        });
    });

    // Checkbox logic
    $("#resellerCheckbox").on("change", function() {
        const $endUserWrapper = $("#endUser").closest(".form-check");
        $endUserWrapper.toggle(!$(this).is(":checked"));
        
        if ($(this).is(":checked")) $("#endUser").prop("checked", false);

        toggleNextButton();
        toggleStep1Checkboxes();
    });

    $("#stepThreeGotoStep4").on("change", function() {
        if ($(this).is(":checked") && currentStep === 3) {
            currentStep = 4;
            updateProgress();
        }
    });

    // Copy address function
    function setupAddressCopy(sourcePrefix, targetPrefix, checkboxSelector) {
        const fields = ['name','email','phone','company_name','designation','address','country','city','zip_code'];
        
        $(checkboxSelector).on('change', function() {
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                fields.forEach(field => {
                    $(`[name="${targetPrefix}${field}"]`).val($(`[name="${sourcePrefix}${field}"]`).val());
                });
            }
        });
    }

    setupAddressCopy('', 'shipping_', '[name="is_contact_address"], .deliveryAddress');
    setupAddressCopy('', 'end_user_', '[name="end_user_is_contact_address"], .endUser');

    updateProgress();
});
</script>
