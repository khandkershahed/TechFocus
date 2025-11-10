<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<!-- jQuery Repeater -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $('#stepperForm').on('submit', function (e) {
        e.preventDefault(); // Stop normal submission

        const form = $(this);

        // Validate form before submitting
        if (!form.valid()) {
            return; // Stop if validation fails
        }

        // Create FormData (works with file uploads)
        const formData = new FormData(this);

        // Disable submit button to prevent multiple clicks
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('Submitting...');

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method') || 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // ✅ SweetAlert success popup
                Swal.fire({
                    icon: 'success',
                    title: 'Your RFQ has been submitted successfully!',
                    text: 'Redirecting to thank you page...',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

              
            },
            error: function (xhr, status, error) {
                // ❌ Handle errors gracefully
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                   html: `<pre style="text-align:left;white-space:pre-wrap;max-height:400px;overflow:auto;">${errorMessage}</pre>`,
                    confirmButtonText: 'OK'
                });
                submitBtn.prop('disabled', false).html('Submit');
            }
        });
    });
});
</script>