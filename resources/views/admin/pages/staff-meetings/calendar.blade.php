@extends('admin.master')

@section('title', 'Meeting Calendar')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt me-2"></i>Meeting Calendar</h1>
        <div>
            <a href="{{ route('admin.staff-meetings.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> Schedule Meeting
            </a>
            <a href="{{ route('admin.staff-meetings.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> List View
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
    #calendar {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        min-height: 600px;
    }
    .fc-event {
        cursor: pointer;
        padding: 3px 6px;
        border-radius: 3px;
        font-size: 0.85em;
    }
    .fc-toolbar-title {
        font-size: 1.5em;
        font-weight: 600;
    }
    .fc-daygrid-event {
        white-space: normal !important;
        word-wrap: break-word;
    }
    .fc-event-title {
        font-weight: 500;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                today: 'Today',
                month: 'Month',
                week: 'Week',
                day: 'Day',
                list: 'List'
            },
            eventClick: function(info) {
                if (info.event.url) {
                    window.open(info.event.url, '_self');
                }
            },
            eventContent: function(info) {
                let timeHtml = '';
                if (info.event.start) {
                    const startTime = info.event.start;
                    timeHtml = `<div class="fc-event-time" style="font-size: 0.8em; margin-bottom: 2px;">
                        ${startTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                    </div>`;
                }
                
                let statusBadge = '';
                if (info.event.extendedProps && info.event.extendedProps.status) {
                    const status = info.event.extendedProps.status;
                    const color = status === 'scheduled' ? 'success' : 
                                 status === 'cancelled' ? 'danger' : 
                                 status === 'completed' ? 'info' : 'warning';
                    statusBadge = `<span class="badge bg-${color}" style="font-size: 0.7em; padding: 2px 5px; margin-left: 3px;">${status}</span>`;
                }
                
                return {
                    html: `
                        <div class="fc-event-main-frame">
                            ${timeHtml}
                            <div class="fc-event-title-container">
                                <div class="fc-event-title" style="font-weight: 500; font-size: 0.85em;">
                                    ${info.event.title}
                                </div>
                            </div>
                            ${statusBadge}
                        </div>
                    `
                };
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            },
            navLinks: true,
            editable: false,
            selectable: false,
            selectMirror: true,
            dayMaxEvents: 3,
            height: 'auto',
            initialDate: new Date(),
            businessHours: {
                daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                startTime: '08:00',
                endTime: '20:00',
            },
            views: {
                dayGridMonth: {
                    dayMaxEventRows: 3
                }
            }
        });
        
        calendar.render();
        
        // Load meeting data via AJAX
        console.log('Loading calendar data...');
        fetch('{{ route("admin.staff-meetings.calendar.data") }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(meetings => {
                console.log('Meetings loaded:', meetings.length);
                
                if (meetings.length === 0) {
                    console.log('No meetings found to display');
                    // Add a placeholder message
                    calendar.addEvent({
                        title: 'No meetings scheduled',
                        start: new Date(),
                        allDay: true,
                        display: 'background',
                        backgroundColor: '#f8f9fa',
                        textColor: '#6c757d',
                        editable: false
                    });
                }
                
                meetings.forEach(meeting => {
                    console.log('Adding meeting:', meeting.title);
                    calendar.addEvent({
                        id: meeting.id,
                        title: meeting.title,
                        start: meeting.start,
                        end: meeting.end,
                        url: meeting.url,
                        extendedProps: {
                            status: meeting.status,
                            category: meeting.category,
                            department: meeting.department,
                            organizer: meeting.organizer,
                            description: meeting.description
                        },
                        backgroundColor: meeting.color,
                        borderColor: meeting.color,
                        textColor: '#ffffff',
                        classNames: ['meeting-event']
                    });
                });
                
                // Refresh calendar to show events
                calendar.refetchEvents();
            })
            .catch(error => {
                console.error('Error loading calendar data:', error);
                // Show error message
                alert('Error loading calendar data. Please check console for details.');
            });
    });
</script>
@endpush
@endsection