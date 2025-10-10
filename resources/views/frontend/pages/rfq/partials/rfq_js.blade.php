<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<!-- jQuery Repeater -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        let currentStep = 1;
        const totalSteps = 4;

        // Custom validation rules
        $.validator.addMethod(
            "customEmail",
            function(value, element) {
                return (
                    this.optional(element) ||
                    /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
                );
            },
            "Please enter a valid email (e.g., user@gmail.com)"
        );

        $.validator.addMethod(
            "customPhone",
            function(value, element) {
                const isValidPattern = /^\d{9,15}$/.test(value);
                return this.optional(element) || isValidPattern;
            },
            "Please enter a valid phone number between 9 and 15 digits."
        );

        $.validator.addMethod(
            "customZip",
            function(value, element) {
                return this.optional(element) || /^[0-9]{4,6}$/.test(value);
            },
            "Please enter a valid ZIP code with 4 to 6 digits"
        );

        $("#stepperForm").validate({
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorPlacement: function(error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            },
            onkeyup: false,
            onfocusout: function(element) {
                $(element).valid();
                toggleNextButton();
                toggleCheckboxes();
            },
            onclick: false,
        });

        $('input[name="email"]').rules("add", {
            customEmail: true
        });
        $('input[name="phone"]').rules("add", {
            customPhone: true
        });
        $('input[name="zip_code"]').rules("add", {
            customZip: true
        });
        $('input[name="shipping_email"]').rules("add", {
            customEmail: true
        });
        $('input[name="shipping_phone"]').rules("add", {
            customPhone: true
        });
        $('input[name="shipping_zip_code"]').rules("add", {
            customZip: true
        });
        $('input[name="product_name"]').rules("add", {
            customProuct: true
        });

        function toggleNextButton() {
            const $currentStepContent = $(`.step-content[data-step="${currentStep}"]`);
            const $requiredInputs = $currentStepContent
                .find("input, select, textarea")
                .filter("[required]");

            let allValid = true;
            if ($requiredInputs.length > 0) {
                $requiredInputs.each(function() {
                    if (!$("#stepperForm").validate().element(this)) {
                        allValid = false;
                        return false;
                    }
                });
            }
            $currentStepContent.find(".next-step").prop("disabled", !allValid);
        }

        function toggleCheckboxes() {
            const $step1 = $('.step-content[data-step="1"]');
            const $requiredInputs = $step1.find("input, select").filter("[required]");
            let allValid = true;

            $requiredInputs.each(function() {
                const isValid = $("#stepperForm").validate().element(this);
                if (!isValid) {
                    allValid = false;
                    return false; // Breaks the .each loop
                }
            });

            // ✅ Fixed selector (removed trailing comma)
            $("#deliveryAddress, #endUser").prop("disabled", !allValid);
        }

        function updateProgress() {
            $(".step").removeClass("active completed current-step-red");

            $(".step").each(function(index) {
                const stepNum = index + 1;
                if (stepNum < currentStep) {
                    $(this).addClass("completed").find("i").show(); // ✅ Show icon only if completed
                } else if (stepNum === currentStep) {
                    $(this).addClass("active current-step-red").find("i")
                        .hide(); // ❌ Hide icon on current step
                } else {
                    $(this).removeClass("completed").find("i")
                        .hide(); // Make sure future steps are clean
                }
            });

            $(".step-content").removeClass("active");
            $(`.step-content[data-step="${currentStep}"]`).addClass("active");

            toggleNextButton();
            toggleCheckboxes();
        }

        $(document).on(
            "input change",
            ".step-content.active input, .step-content.active select, .step-content.active textarea",
            function() {
                toggleNextButton();
                toggleCheckboxes();
            }
        );

        $(".next-step").click(function() {
            const $currentStepContent = $(`.step-content[data-step="${currentStep}"]`);
            const $requiredInputs = $currentStepContent
                .find("input, select, textarea")
                .filter("[required]");

            if ($requiredInputs.length === 0 || $requiredInputs.valid()) {
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
            } else {
                $requiredInputs.valid();
            }
        });

        $(".prev-step").click(function() {
            if (currentStep > 1) {
                currentStep--;
                updateProgress();
            }
        });


        let isSubmitting = false;

        $("#stepperForm").on("submit", function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            if ($(this).valid()) {
                isSubmitting = true;

                // Optional: Disable submit button
                $(this).find('button[type="submit"]').prop('disabled', true);
                $(this).find('button[type="submit"]').html('Submitting...');

                // Use native form submission
                this.submit();
            } else {
                e.preventDefault(); // Prevent submission if invalid
            }
        });



        function handleCheckboxVisibility() {
            const $checkDefaultWrapper = $("#endUser").closest(".form-check");
            if ($("#resellerCheckbox").is(":checked")) {
                $checkDefaultWrapper.hide();
                $("#endUser").prop("checked", false);
            } else {
                $checkDefaultWrapper.show();
            }
        }

        $("#resellerCheckbox").on("change", function() {
            handleCheckboxVisibility();
            toggleNextButton();
            toggleCheckboxes();
        });

        function setupStepTwoJumpCheckbox() {
            $("#stepTwoGotoStep3").on("change", function() {
                if ($(this).is(":checked") && currentStep === 2) {
                    currentStep = 3;
                    updateProgress();
                }
            });
        }

        function setupStepTwoJumpCheckboxThree() {
            $("#stepThreeGotoStep4").on("change", function() {
                if ($(this).is(":checked") && currentStep === 3) {
                    currentStep = 4;
                    updateProgress();
                }
            });
        }
        // Initial run
        handleCheckboxVisibility();
        updateProgress();
        setupStepTwoJumpCheckbox();
        setupStepTwoJumpCheckboxThree();
    });

    // Country placeholder
    const selects = document.getElementsByClassName("countrySelect");

    for (let i = 0; i < selects.length; i++) {
        const select = selects[i];

        // Initial color set
        if (select.value === "") {
            select.style.color = "#888888b2";
        }

        // On change
        select.addEventListener("change", function() {
            if (select.value === "") {
                select.style.color = "#888888b2";
            } else {
                select.style.color = "#000";
            }
        });
    }

    function toggleDiv() {
        const checkbox = document.getElementById("delivery");
        const toggleContent = document.getElementById("toggle-content");
        toggleContent.style.display = checkbox.checked ? "block" : "none";
    }
</script>
<script>
    function increment(button) {
        const input = button.closest('.counting-btn').previousElementSibling;
        let value = parseInt(input.value);
        input.value = isNaN(value) || value < 1 ? 1 : value + 1;
    }

    function decrement(button) {
        const input = button.closest('.counting-btn').previousElementSibling;
        let value = parseInt(input.value);
        if (isNaN(value) || value <= 1) {
            input.value = 1;
        } else {
            input.value = value - 1;
        }
    }
</script>
<script>
    function updateSerials() {
        $('[data-repeater-list] [data-repeater-item]').each(function(i) {
            $(this).find('.sl-input').val(i + 1);
        });
    }

    function deleteRFQFromServer(rowId, onSuccess) {
        var cartHeader = $('.miniRFQQTY');
        var offcanvasRFQ = $('.offcanvasRFQ');

        $.ajax({
            type: 'GET',
            url: "rfq-remove/" + rowId,
            dataType: 'json',
            success: function(data) {
                // Update cart header
                cartHeader.empty();
                if (data.cartHeader > 0) {
                    const label = data.cartHeader > 1 ? 'Item(s)' : 'Item';
                    cartHeader.append(`${data.cartHeader} ${label} Added`);
                } else {
                    cartHeader.append('Ask Query');
                }

                // Update RFQ contents
                offcanvasRFQ.html(data.html);

                // Show success message
                Swal.fire({
                    icon: 'info',
                    title: 'Successfully Removed from RFQ!',
                    showConfirmButton: false,
                    timer: 1500
                });

                if (typeof onSuccess === 'function') {
                    onSuccess();
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Something happened. Try again.',
                    text: error,
                    showConfirmButton: true
                });
            }
        });
    }

    $(document).ready(function() {
        $('.repeater').repeater({
            show: function() {
                const $row = $(this);
                $row.slideDown('fast', function() {
                    updateSerials();
                });

                // Assign a unique modal ID for this row
                const $modal = $row.find('.modal');
                if ($modal.length) {
                    const modalId = 'modal-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
                    $modal.attr('id', modalId);
                    $modal.find('.modal-title').attr('id', modalId + 'Label');

                    // Update the modal button's target
                    const $button = $row.find('[data-bs-toggle="modal"]');
                    $button.attr('data-bs-target', '#' + modalId);
                }
            },
            hide: function(deleteElement) {
                const $item = $(this);
                const $list = $item.closest('[data-repeater-list]');
                const itemCount = $list.find('[data-repeater-item]').length;

                if (itemCount > 1) {
                    // Remove item with slide animation
                    $item.slideUp('fast', function() {
                        deleteElement(); // Properly remove repeater item
                        updateSerials(); // Update serial numbers
                    });
                } else {
                    // Optional: keep at least one item
                    alert('At least one item must remain.');
                }
            },
            isFirstItemUndeletable: false
        });

        updateSerials(); // Initial run
    });
</script>
<script>
    $(document).ready(function() {
        const fieldPairs = [
            ['shipping_name', 'name'],
            ['shipping_email', 'email'],
            ['shipping_phone', 'phone'],
            ['shipping_company_name', 'company_name'],
            ['shipping_designation', 'designation'],
            ['shipping_address', 'address'],
            ['shipping_country', 'country'],
            ['shipping_city', 'city'],
            ['shipping_zip_code', 'zip_code']
        ];

        $('[name="is_contact_address"], .deliveryAddress').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('[name="is_contact_address"]').prop('checked', isChecked);
            $('.deliveryAddress').prop('checked', isChecked);
            fieldPairs.forEach(([shippingName, contactName]) => {
                const value = isChecked ? $(`[name="${contactName}"]`).val() : '';
                $(`[name="${shippingName}"]`).val(value);
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        const fieldPairs = [
            ['end_user_name', 'name'],
            ['end_user_email', 'email'],
            ['end_user_phone', 'phone'],
            ['end_user_company_name', 'company_name'],
            ['end_user_designation', 'designation'],
            ['end_user_address', 'address'],
            ['end_user_country', 'country'],
            ['end_user_city', 'city'],
            ['end_user_zip_code', 'zip_code']
        ];

        $('[name="end_user_is_contact_address"], .endUser').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('[name="end_user_is_contact_address"]').prop('checked', isChecked);
            $('.endUser').prop('checked', isChecked);

            fieldPairs.forEach(([shippingName, contactName]) => {
                const value = isChecked ? $(`[name="${contactName}"]`).val() : '';
                $(`[name="${shippingName}"]`).val(value);
            });
        });
    });
</script>
<script>
    const productInput = document.querySelector('[name="product_name"]');
    const fileInput = document.querySelector('.file-input');
    const warningText = document.querySelector('.warning-text');

    function checkProductName() {
        if (productInput.value.trim() === "") {
            fileInput.disabled = true;
            warningText.style.display = "block"; // Show text
        } else {
            fileInput.disabled = false;
            warningText.style.display = "none"; // Hide text
        }
    }

    // Run check while typing
    productInput.addEventListener('input', checkProductName);

    // Run check on page load too
    checkProductName();


    ///iamge section 

    document.getElementById('mainForm').addEventListener('submit', function(e){
    e.preventDefault(); // prevent normal submission
    const form = this;
    const formData = new FormData(form);

    // Append selected images from modal
    selectedImages.forEach((file, index) => {
        formData.append(`contacts[${index}][image]`, file);
    });

    fetch(form.action, {
        method: 'POST',
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        console.log('Submitted:', data);
        alert('Form submitted successfully!');
    })
    .catch(err => console.error(err));
});

</script>