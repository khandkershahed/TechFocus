@extends('admin.master')

@section('title', 'Staff Meetings Calendar')

@push('styles')
<!-- Remove any global CKEditor styles if they exist -->
<style>
    /* Hide any CKEditor elements that might appear */
    .ck-editor, .ck, .ck-content, .ck-toolbar {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt me-2"></i>Staff Meetings Calendar</h1>
        <div>
            <a href="{{ route('admin.staff-meetings.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-list"></i> List View
            </a>
            <a href="{{ route('admin.staff-meetings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Schedule New Meeting
            </a>
        </div>
    </div>

    <!-- Simple Calendar -->
    <div class="card">
        <div class="card-body">
            <h4 class="text-center mb-4">{{ date('F Y') }}</h4>
            
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $firstDay = date('w', strtotime(date('Y-m-01')));
                            $daysInMonth = date('t');
                            $day = 1;
                        @endphp
                        
                        @for($i = 0; $i < 6; $i++)
                            <tr>
                                @for($j = 0; $j < 7; $j++)
                                    @if(($i == 0 && $j < $firstDay) || $day > $daysInMonth)
                                        <td class="text-muted bg-light">&nbsp;</td>
                                    @else
                                        @php
                                            $currentDate = date('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                                            $meetingsToday = \App\Models\StaffMeeting::whereDate('date', $currentDate)->get();
                                        @endphp
                                        <td class="{{ $currentDate == date('Y-m-d') ? 'bg-info text-white' : '' }}">
                                            <div class="fw-bold">{{ $day }}</div>
                                            @if($meetingsToday->count() > 0)
                                                <div class="small mt-1">
                                                    <span class="badge bg-success">{{ $meetingsToday->count() }} meetings</span>
                                                </div>
                                                @foreach($meetingsToday->take(2) as $meeting)
                                                    <div class="small mt-1">
                                                        <span class="badge bg-primary" 
                                                              onclick="window.location='{{ route('admin.staff-meetings.show', $meeting) }}'"
                                                              style="cursor: pointer;">
                                                            {{ $meeting->start_time->format('h:i') }} - {{ Str::limit($meeting->title, 10) }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                                @if($meetingsToday->count() > 2)
                                                    <div class="small mt-1">
                                                        <span class="badge bg-secondary">+{{ $meetingsToday->count() - 2 }} more</span>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        @php $day++; @endphp
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Prevent CKEditor errors
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR = undefined;
}
if (typeof ClassicEditor !== 'undefined') {
    ClassicEditor = undefined;
}
</script>
@endpush

@endsection