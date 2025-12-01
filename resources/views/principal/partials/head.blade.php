<base href="">
<title>TechFocus | Principal Layout</title>
<meta charset="utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="TechFocus" />
<meta property="og:url" content="" />
<meta property="og:site_name" content="TechFocus" />
<link rel="shortcut icon"
    href="{{ !empty($site->site_icon) && file_exists(public_path('storage/webSetting/siteIcon/' . $site->site_icon)) ? asset('storage/webSetting/siteIcon/' . $site->site_icon) : asset('backend/images/no-image-available.png') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link href="{{ asset('backend/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('backend/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ asset('backend/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
    rel="stylesheet" />
<link href="{{ asset('backend/assets/css/custom/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('backend/assets/js/custom/input-tags/css/tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/css/custom_global.css') }}">
@stack('styles')

<style>
    .fl-wrapper {
        top: 1.5rem !important;
        z-index: 9999 !important;
    }
</style>