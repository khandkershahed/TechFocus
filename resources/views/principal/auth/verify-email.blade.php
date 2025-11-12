@extends('frontend.master')

@section('content')
<section class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg" style="max-width: 450px; width: 100%;">
        <h3 class="text-center fw-bold mb-3">Verify Your Email</h3>
        <p class="text-center text-muted">A verification link has been sent to your email. Please verify to continue.</p>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('swal'))
        let swalData = @json(session('swal'));
        Swal.fire({
            icon: swalData.icon || 'info',
            title: swalData.title || '',
            text: swalData.text || '',
            timer: swalData.timer || 4000,
            showConfirmButton: false,
            timerProgressBar: true,
        });
    @endif
});
</script>
@endpush
