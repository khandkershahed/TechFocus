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
    }
    .fc-event {
        cursor: pointer;
    }
    .fc-toolbar-title {
        font-size: 1.5em;
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
            events: @json($meetings),
            eventClick: function(info) {
                window.location.href = "{{ url('staff-meetings') }}/" + info.event.id;
            },
            eventContent: function(info) {
                let timeHtml = '';
                if (info.event.extendedProps.start_time) {
                    const startTime = new Date(info.event.extendedProps.start_time);
                    timeHtml = `<div class="fc-event-time">${startTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>`;
                }
                
                let statusBadge = '';
                if (info.event.extendedProps.status) {
                    const status = info.event.extendedProps.status;
                    const color = status === 'scheduled' ? 'success' : 
                                 status === 'cancelled' ? 'danger' : 
                                 status === 'completed' ? 'info' : 'warning';
                    statusBadge = `<span class="badge bg-${color} float-end">${status}</span>`;
                }
                
                return {
                    html: `
                        <div class="fc-event-main-frame">
                            ${timeHtml}
                            <div class="fc-event-title-container">
                                <div class="fc-event-title">${info.event.title}</div>
                                ${statusBadge}
                            </div>
                        </div>
                    `
                };
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: 'short'
            },
            navLinks: true,
            editable: false,
            selectable: false,
            eventDisplay: 'block',
            height: 'auto',
            businessHours: {
                daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                startTime: '09:00',
                endTime: '18:00',
            }
        });
        
        calendar.render();
        
        // Add meeting data to calendar
        fetch('/staff-meetings/calendar-data')
            .then(response => response.json())
            .then(meetings => {
                meetings.forEach(meeting => {
                    calendar.addEvent({
                        id: meeting.id,
                        title: meeting.title,
                        start: meeting.start_time,
                        end: meeting.end_time,
                        extendedProps: {
                            status: meeting.status,
                            category: meeting.category,
                            department: meeting.department
                        },
                        backgroundColor: getEventColor(meeting.status),
                        borderColor: getEventColor(meeting.status),
                        textColor: '#ffffff'
                    });
                });
            });
        
        function getEventColor(status) {
            switch(status) {
                case 'scheduled': return '#28a745';
                case 'cancelled': return '#dc3545';
                case 'completed': return '#17a2b8';
                case 'rescheduled': return '#ffc107';
                default: return '#007bff';
            }
        }
    });
</script>
@endpush
@endsection