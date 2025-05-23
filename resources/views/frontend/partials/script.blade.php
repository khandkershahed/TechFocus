{{-- <script src="{{ asset('frontend/assets/js/plugin/bootstrap@5.2.3.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugin/bootstrap@5.2.3.bundle.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('frontend/assets/js/plugin/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugin/swiper-bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script src="{{ asset('frontend/assets/js/plugin/aos@2.3.1.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugin/fontawesome.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/xzoom@1.0.14/dist/xzoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myAccordion = new bootstrap.Collapse(document.getElementById('accordionFlushExample'));
    });
</script>
<script>
    AOS.init();
</script>
<!-- Aos Scroll Animation End-->
<!-- Custom JS -->
<script src="{{ asset('frontend/assets/js/header.js') }}"></script>
<script src="{{ asset('frontend/assets/js/scripts.js') }}"></script>

@stack('scripts')

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif
</script>
