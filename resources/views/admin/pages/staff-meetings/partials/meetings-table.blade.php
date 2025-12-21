<style>
    /* ================= MODERN TABLE CONTAINER ================= */
    .modern-table-container {
        background: transparent;
        border-radius: var(--table-radius);
        box-shadow: var(--table-shadow);
        overflow: hidden;
        border: 1px solid var(--table-border);
    }

    .table-responsive {
        position: relative;
        min-height: 400px;
    }

    /* ================= TABLE STYLING ================= */
    .modern-table {
        width: 100%;
        min-width: 1000px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .modern-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modern-table th {
        padding: 16px 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--table-border);
        white-space: nowrap;
        text-align: left;
        position: relative;
    }

    .modern-table th:after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
    }

    .modern-table th:last-child:after {
        display: none;
    }

    .modern-table td {
        padding: 20px;
        font-size: 13px;
        color: var(--table-text);
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        line-height: 1.4;
        transition: all 0.2s ease;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
        position: relative;
    }

    .modern-table tbody tr:hover {
        background: var(--table-hover);
        transform: translateX(2px);
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ================= COLUMN SPECIFIC STYLES ================= */
    /* Date Column */
    .date-cell {
        min-width: 120px;
    }

    .date-main {
        font-size: 14px;
        font-weight: 600;
        color: var(--table-text);
        display: block;
    }

    .date-sub {
        font-size: 11px;
        color: var(--table-text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
        display: block;
    }

    /* Time Column */
    .time-cell {
        min-width: 130px;
    }

    .time-main {
        font-weight: 600;
        color: var(--table-text);
        font-size: 13px;
        display: block;
    }

    .time-range {
        font-size: 11px;
        color: var(--table-text-light);
        margin-top: 2px;
        display: block;
    }

    .time-duration {
        font-size: 11px;
        color: var(--table-accent);
        background: rgba(99, 102, 241, 0.1);
        padding: 2px 6px;
        border-radius: 10px;
        display: inline-block;
        margin-top: 4px;
    }

    /* Title Column */
    .title-cell {
        min-width: 200px;
        max-width: 250px;
    }

    .title-main {
        font-weight: 600;
        color: var(--table-text);
        font-size: 14px;
        line-height: 1.3;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .title-agenda {
        font-size: 12px;
        color: var(--table-text-light);
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .title-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    /* Department Column */
    .dept-cell {
        min-width: 100px;
    }

    /* Organizer Column */
    .organizer-cell {
        min-width: 140px;
    }

    .organizer-name {
        font-weight: 500;
        color: var(--table-text);
        font-size: 13px;
        display: block;
        margin-bottom: 2px;
    }

    .organizer-email {
        font-size: 11px;
        color: var(--table-text-light);
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Participants Column */
    .participants-cell {
        min-width: 120px;
    }

    /* Status Column */
    .status-cell {
        min-width: 100px;
    }

    /* Actions Column */
    .actions-cell {
        min-width: 180px;
    }

    /* ================= BADGE STYLES ================= */
    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        line-height: 1;
        border: 1px solid;
        transition: all 0.2s ease;
    }

    .badge-category {
        background: rgba(99, 102, 241, 0.1);
        color: var(--table-accent);
        border-color: rgba(99, 102, 241, 0.2);
    }

    .badge-type {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.2);
    }

    .badge-dept {
        background: rgba(14, 165, 233, 0.1);
        color: #0ea5e9;
        border-color: rgba(14, 165, 233, 0.2);
        padding: 4px 8px;
    }

    .badge-participants {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid;
    }

    .status-scheduled {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
        color: #065f46;
        border-color: rgba(16, 185, 129, 0.2);
    }

    .status-completed {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(14, 165, 233, 0.05));
        color: #0c4a6e;
        border-color: rgba(14, 165, 233, 0.2);
    }

    .status-cancelled {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
        color: #991b1b;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .status-rescheduled {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
        color: #92400e;
        border-color: rgba(245, 158, 11, 0.2);
    }

    /* ================= ACTION BUTTONS ================= */
    .action-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--table-border);
        background: white;
        color: var(--table-text-light);
        font-size: 13px;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-icon.view:hover {
        background: #dbeafe;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .btn-icon.edit:hover {
        background: #f0f9ff;
        color: #0ea5e9;
        border-color: #bae6fd;
    }

    .btn-icon.delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }

    .btn-icon.complete:hover {
        background: #d1fae5;
        color: #065f46;
        border-color: #a7f3d0;
    }

    /* Present Button */
    .btn-present {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .btn-present:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .btn-present:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Present Button States */
    .btn-present.pending {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .btn-present.approved {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .btn-present.rejected {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .btn-present.recorded {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    /* ================= HR ACTIONS ================= */
    .hr-actions {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-hr {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--table-border);
        background: white;
        color: var(--table-text-light);
        font-size: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .btn-hr:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-hr.email:hover {
        background: #e0f2fe;
        color: #0ea5e9;
        border-color: #bae6fd;
    }

    .btn-hr.whatsapp:hover {
        background: #d1fae5;
        color: #10b981;
        border-color: #a7f3d0;
    }

    .btn-hr.link:hover {
        background: #ede9fe;
        color: #8b5cf6;
        border-color: #ddd6fe;
    }

    .btn-hr.qr:hover {
        background: #fef3c7;
        color: #f59e0b;
        border-color: #fde68a;
    }

    .btn-hr.minutes:hover {
        background: #f1f5f9;
        color: #475569;
        border-color: #e2e8f0;
    }

    /* ================= PARTICIPANTS POPOVER ================= */
    .participants-popover {
        background: white;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        border: 1px solid var(--table-border);
        padding: 0;
        max-width: 300px;
    }

    .participants-list {
        max-height: 200px;
        overflow-y: auto;
        padding: 12px;
    }

    .participant-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        border-radius: 6px;
        transition: background 0.2s ease;
    }

    .participant-item:hover {
        background: #f8fafc;
    }

    .participant-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 600;
    }

    .participant-name {
        font-size: 12px;
        color: var(--table-text);
        flex: 1;
    }

    /* ================= EMPTY STATE ================= */
    .empty-table {
        padding: 60px 20px;
        text-align: center;
        color: var(--table-text-light);
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--table-text);
        margin-bottom: 8px;
    }

    .empty-subtitle {
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* ================= PAGINATION ================= */
    .table-pagination {
        padding: 20px;
        border-top: 1px solid var(--table-border);
        background: white;
        display: flex;
        justify-content: center;
    }

    .pagination-modern {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .page-link-modern {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid var(--table-border);
        color: var(--table-text);
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .page-link-modern:hover {
        background: var(--table-hover);
        border-color: var(--table-accent);
        color: var(--table-accent);
    }

    .page-link-modern.active {
        background: linear-gradient(135deg, var(--table-accent), #8b5cf6);
        color: white;
        border-color: var(--table-accent);
    }

    /* ================= RESPONSIVE DESIGN ================= */
    @media (max-width: 1200px) {
        .modern-table-container {
            border-radius: 8px;
        }
        
        .modern-table th,
        .modern-table td {
            padding: 14px 16px;
        }
    }

    @media (max-width: 768px) {
        .action-group,
        .hr-actions {
            flex-direction: column;
            gap: 4px;
        }
        
        .btn-icon,
        .btn-hr {
            width: 28px;
            height: 28px;
        }
        
        .btn-present {
            padding: 4px 8px;
            font-size: 10px;
        }
    }

    /* ================= ANIMATIONS ================= */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modern-table tbody tr {
        animation: fadeIn 0.3s ease forwards;
    }

    /* ================= TABLE LOADING STATE ================= */
    .table-loading {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        border-radius: var(--table-radius);
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(99, 102, 241, 0.1);
        border-top-color: var(--table-accent);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

@if($meetings->count() > 0)
    <div class="modern-table-container">
        <div class="table-responsive">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Time</th>
                        <th>Meeting Details</th>
                        <th>Department</th>
                        <th>Organizer</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>HR Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meetings as $meeting)
                        <tr>
                            <!-- Date Column -->
                            <td class="date-cell">
                                <span class="date-main">
                                    {{ $meeting->date->format('d M Y') }}
                                </span>
                                <span class="date-sub">
                                    {{ $meeting->date->format('l') }}
                                </span>
                            </td>
                            
                            <!-- Time Column -->
                            <td class="time-cell">
                                <span class="time-main">
                                    {{ $meeting->start_time->format('h:i A') }}
                                </span>
                                <span class="time-range">
                                    to {{ $meeting->end_time->format('h:i A') }}
                                </span>
                                @if($meeting->duration)
                                    <span class="time-duration">
                                        <i class="fas fa-clock"></i>
                                        @php
                                            $start = \Carbon\Carbon::parse($meeting->start_time);
                                            $end = \Carbon\Carbon::parse($meeting->end_time);
                                            $duration = $start->diff($end);
                                        @endphp
                                        {{ $duration->h }}h {{ $duration->i }}m
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Meeting Details Column -->
                            <td class="title-cell">
                                <div class="title-main">
                                    {{ $meeting->title }}
                                </div>
                                <div class="title-agenda">
                                    {{ $meeting->agenda ? \Illuminate\Support\Str::limit($meeting->agenda, 80) : 'No agenda provided' }}
                                </div>
                                <div class="title-tags">
                                    <span class="badge-modern badge-category">
                                        <i class="fas fa-tag"></i>
                                        {{ ucfirst(str_replace('_', ' ', $meeting->category)) }}
                                    </span>
                                    @if($meeting->type)
                                        <span class="badge-modern badge-type">
                                            <i class="fas fa-users"></i>
                                            {{ ucfirst($meeting->type) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Department Column -->
                            <td class="dept-cell">
                                <span class="badge-modern badge-dept">
                                    <i class="fas fa-building"></i>
                                    {{ $meeting->department ?? 'General' }}
                                </span>
                            </td>
                            
                            <!-- Organizer Column -->
                            <td class="organizer-cell">
                                @if($meeting->organizer)
                                    <span class="organizer-name">
                                        {{ $meeting->organizer->name }}
                                    </span>
                                    <span class="organizer-email">
                                        {{ $meeting->organizer->email ?? 'Email not available' }}
                                    </span>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
                            
                            <!-- Participants Column -->
                            <td class="participants-cell">
                                @php
                                    $participantsArray = json_decode($meeting->participants, true) ?? [];
                                    $participantsCount = is_array($participantsArray) ? count($participantsArray) : 0;
                                @endphp
                                
                                @if($participantsCount > 0)
                                    <div class="gap-2 d-flex align-items-center">
                                        <span class="badge-modern badge-participants">
                                            <i class="fas fa-user-friends"></i>
                                            {{ $participantsCount }}
                                        </span>
                                        <button type="button" 
                                                class="btn-icon view"
                                                data-bs-toggle="popover" 
                                                data-bs-html="true"
                                                data-bs-custom-class="participants-popover"
                                                data-bs-title="<div class='gap-2 d-flex align-items-center'><i class='fas fa-user-friends'></i> Participants</div>"
                                                data-bs-content="
                                                    <div class='participants-list'>
                                                        @if($participantsCount > 0)
                                                            @php
                                                                $participantIds = $participantsArray;
                                                                $participants = \App\Models\Admin::whereIn('id', $participantIds)->get();
                                                            @endphp
                                                            @foreach($participants as $participant)
                                                                <div class='participant-item'>
                                                                    <div class='participant-avatar'>
                                                                        {{ strtoupper(substr($participant->name, 0, 1)) }}
                                                                    </div>
                                                                    <div class='participant-name'>{{ $participant->name }}</div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class='py-4 text-center text-muted'>No participants</div>
                                                        @endif
                                                    </div>
                                                ">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted">No participants</span>
                                @endif
                            </td>
                            
                            <!-- Status Column -->
                            <td class="status-cell">
                                @php
                                    $statusConfig = [
                                        'scheduled' => ['class' => 'status-scheduled', 'icon' => 'fas fa-clock'],
                                        'completed' => ['class' => 'status-completed', 'icon' => 'fas fa-check-circle'],
                                        'cancelled' => ['class' => 'status-cancelled', 'icon' => 'fas fa-times-circle'],
                                        'rescheduled' => ['class' => 'status-rescheduled', 'icon' => 'fas fa-calendar-alt']
                                    ][$meeting->status] ?? ['class' => 'bg-secondary', 'icon' => 'fas fa-question-circle'];
                                @endphp
                                
                                <span class="status-badge {{ $statusConfig['class'] }}">
                                    <i class="{{ $statusConfig['icon'] }}"></i>
                                    {{ ucfirst($meeting->status) }}
                                </span>
                            </td>
                            
                            <!-- Actions Column -->
                            <td class="actions-cell">
                                <div class="action-group">
                                    <a href="{{ route('admin.staff-meetings.show', $meeting) }}" 
                                       class="btn-icon view"
                                       title="View Details"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.staff-meetings.edit', $meeting) }}" 
                                       class="btn-icon edit"
                                       title="Edit Meeting"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Present Button -->
                                    @if($meeting->status === 'scheduled' && $meeting->date->isToday())
                                        @php
                                            $attendanceStatus = $meeting->getAttendanceStatus(auth('admin')->id());
                                            $btnClass = 'btn-present';
                                            $btnText = 'P';
                                            $disabled = false;
                                            
                                            if($attendanceStatus) {
                                                switch($attendanceStatus->status) {
                                                    case 'approved':
                                                        $btnClass .= ' approved';
                                                        $btnText = '<i class="fas fa-check-double"></i>';
                                                        $disabled = true;
                                                        break;
                                                    case 'pending':
                                                        $btnClass .= ' pending';
                                                        $btnText = '<i class="fas fa-clock"></i>';
                                                        $disabled = true;
                                                        break;
                                                    case 'rejected':
                                                        $btnClass .= ' rejected';
                                                        $btnText = '<i class="fas fa-times"></i>';
                                                        $disabled = true;
                                                        break;
                                                    default:
                                                        $btnClass .= ' recorded';
                                                        $btnText = '<i class="fas fa-clipboard-check"></i>';
                                                        $disabled = true;
                                                }
                                            }
                                        @endphp
                                        
                                        <button class="{{ $btnClass }} mark-present-btn" 
                                                data-meeting-id="{{ $meeting->id }}"
                                                data-meeting-title="{{ $meeting->title }}"
                                                title="{{ $attendanceStatus ? ucfirst($attendanceStatus->status) . ' attendance' : 'Mark yourself as present' }}"
                                                data-bs-toggle="tooltip"
                                                {!! $disabled ? 'disabled' : '' !!}>
                                            {!! $btnText !!}
                                        </button>
                                    @endif
                                    
                                    <!-- Complete Button -->
                                    @if($meeting->status === 'scheduled')
                                        <form action="{{ route('admin.staff-meetings.update-status', $meeting) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Mark this meeting as completed?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" 
                                                    class="btn-icon complete"
                                                    title="Mark as Completed"
                                                    data-bs-toggle="tooltip">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.staff-meetings.destroy', $meeting) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this meeting?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-icon delete"
                                                title="Delete Meeting"
                                                data-bs-toggle="tooltip">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            <!-- HR Tools Column -->
                            <td>
                                <div class="hr-actions">
                                    <!-- Send Reminders -->
                                    @if($meeting->canSendReminder())
                                        <button type="button" 
                                                class="btn-hr email" 
                                                onclick="sendReminder('email', {{ $meeting->id }})"
                                                title="Send Email Reminder">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn-hr whatsapp" 
                                                onclick="sendReminder('whatsapp', {{ $meeting->id }})"
                                                title="Send WhatsApp Reminder">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Generate Links -->
                                    @if($meeting->platform == 'online' && !$meeting->meeting_link)
                                        <button type="button" 
                                                class="btn-hr link"
                                                onclick="generateMeetingLink({{ $meeting->id }})"
                                                title="Generate Meeting Link">
                                            <i class="fas fa-link"></i>
                                        </button>
                                    @endif
                                    
                                    <!-- Attendance QR -->
                                    <button type="button" 
                                            class="btn-hr qr"
                                            onclick="generateQRCode({{ $meeting->id }})"
                                            title="Generate Attendance QR Code">
                                        <i class="fas fa-qrcode"></i>
                                    </button>
                                    
                                    <!-- Upload Minutes -->
                                    @if($meeting->status == 'completed' && !$meeting->meeting_minutes)
                                        <a href="{{ route('admin.staff-meetings.show', $meeting) }}#minutes" 
                                           class="btn-hr minutes"
                                           title="Upload Minutes">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="table-pagination">
            <div class="pagination-modern">
                {{ $meetings->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@else
    <div class="empty-table">
        <i class="fas fa-calendar-times empty-icon"></i>
        <h4 class="empty-title">No meetings found</h4>
        <p class="empty-subtitle">No meetings match your current filters</p>
        <button id="clear-all-filters" class="btn btn-primary btn-sm">
            <i class="fas fa-times me-2"></i>Clear Filters
        </button>
    </div>
@endif

<!-- Mark Present Modal -->
<div class="modal fade" id="markPresentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-check me-2"></i>Mark Attendance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4 text-center">
                    <i class="mb-3 fas fa-check-circle fa-3x text-primary"></i>
                    <h5 id="meetingTitleDisplay"></h5>
                    <p class="mb-0 text-muted">Confirm your attendance for this meeting</p>
                </div>
                
                <div class="border alert alert-light">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-primary me-3"></i>
                        <div>
                            <p class="mb-0">Your attendance request will be sent to the admin for approval.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3 form-check">
                    <input type="checkbox" class="form-check-input" id="confirmAttendance">
                    <label class="form-check-label" for="confirmAttendance">
                        I confirm that I will attend this meeting
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmPresentBtn" disabled>
                    <i class="fas fa-check-circle me-2"></i>Confirm Attendance
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Initialize tooltips and popovers
$(document).ready(function() {
    // Tooltips
    $('[data-bs-toggle="tooltip"]').tooltip({
        trigger: 'hover',
        placement: 'top'
    });
    
    // Popovers for participants
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl, {
        trigger: 'click',
        placement: 'left',
        html: true,
        sanitize: false
    }));
    
    // Clear filters button
    $('#clear-all-filters').click(function() {
        $('.filter-input').val('');
        loadMeetings();
    });
    
    // Initialize Mark Present functionality
    initMarkPresent();
});

// Mark Present functionality (same as before, but updated for new button classes)
function initMarkPresent() {
    let currentMeetingId = null;
    
    $(document).on('click', '.mark-present-btn:not(:disabled)', function(e) {
        e.preventDefault();
        currentMeetingId = $(this).data('meeting-id');
        const meetingTitle = $(this).data('meeting-title');
        
        $('#meetingTitleDisplay').text(meetingTitle);
        $('#confirmAttendance').prop('checked', false);
        $('#confirmPresentBtn').prop('disabled', true);
        
        $('#markPresentModal').modal('show');
    });
    
    $('#confirmAttendance').on('change', function() {
        $('#confirmPresentBtn').prop('disabled', !$(this).is(':checked'));
    });
    
    $('#confirmPresentBtn').click(function() {
        if (!currentMeetingId) return;
        
        const adminId = @json(auth('admin')->id());
        if (!adminId) {
            showNotification('error', 'You must be logged in to mark attendance.', {
                title: 'Authentication Required'
            });
            return;
        }
        
        const btn = $(this);
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Submitting...');
        btn.prop('disabled', true);
        
        submitAttendanceRequest(currentMeetingId, adminId, btn, originalText);
    });
    
    function submitAttendanceRequest(meetingId, staffId, btn, originalText) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        if (!csrfToken) {
            showNotification('error', 'Security token not found. Please refresh the page.', {
                title: 'Security Error'
            });
            btn.html(originalText);
            btn.prop('disabled', false);
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.attendance.submit-request") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                meeting_id: meetingId,
                staff_id: staffId
            },
            success: function(response) {
                if (response.success) {
                    showNotification('success', response.message, {
                        title: 'Success!',
                        duration: 5000
                    });
                    
                    $('#markPresentModal').modal('hide');
                    
                    // Update all matching buttons
                    const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
                    meetingBtns.each(function() {
                        $(this).html('<i class="fas fa-check"></i>');
                        $(this).removeClass('btn-present').addClass('btn-present pending');
                        $(this).prop('disabled', true);
                        $(this).attr('title', 'Attendance request submitted');
                    });
                } else {
                    handleAttendanceError(response, meetingId);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Network error. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMessage = 'Validation error. Please check your input.';
                } else if (xhr.status === 401) {
                    errorMessage = 'You must be logged in to mark attendance.';
                }
                
                showNotification('error', errorMessage, {
                    title: 'Submission Failed'
                });
            },
            complete: function() {
                btn.html(originalText);
                btn.prop('disabled', false);
            }
        });
    }
    
    function handleAttendanceError(result, meetingId) {
        const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
        
        switch(result.type) {
            case 'already_approved':
                showNotification('info', 'Your attendance for this meeting has already been approved.', {
                    title: 'Already Approved',
                    icon: 'fas fa-check-circle'
                });
                meetingBtns.html('<i class="fas fa-check-double"></i>')
                    .removeClass('btn-present')
                    .addClass('btn-present approved')
                    .prop('disabled', true);
                break;
                
            case 'pending_exists':
                showNotification('warning', 'You already have a pending request for this meeting.', {
                    title: 'Request Pending',
                    icon: 'fas fa-clock'
                });
                meetingBtns.html('<i class="fas fa-clock"></i>')
                    .removeClass('btn-present')
                    .addClass('btn-present pending')
                    .prop('disabled', true);
                break;
                
            case 'rejected_exists':
                showNotification('error', 'Your previous request was rejected. Please contact admin.', {
                    title: 'Request Rejected',
                    icon: 'fas fa-times-circle'
                });
                meetingBtns.html('<i class="fas fa-times"></i>')
                    .removeClass('btn-present')
                    .addClass('btn-present rejected')
                    .prop('disabled', true);
                break;
                
            case 'attendance_exists':
                showNotification('info', 'Attendance already recorded for this meeting.', {
                    title: 'Already Recorded',
                    icon: 'fas fa-clipboard-check'
                });
                meetingBtns.html('<i class="fas fa-clipboard-check"></i>')
                    .removeClass('btn-present')
                    .addClass('btn-present recorded')
                    .prop('disabled', true);
                break;
                
            default:
                showNotification('error', result.message || 'Failed to submit attendance request.', {
                    title: 'Error',
                    icon: 'fas fa-exclamation-triangle'
                });
        }
    }
    
    function showNotification(type, message, options = {}) {
        const title = options.title || type.charAt(0).toUpperCase() + type.slice(1);
        const icon = options.icon || 
            (type === 'success' ? 'fas fa-check-circle' : 
             type === 'warning' ? 'fas fa-exclamation-triangle' : 
             type === 'info' ? 'fas fa-info-circle' :
             'fas fa-times-circle');
        const duration = options.duration || 3000;
        
        $('.attendance-notification').remove();
        
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' :
                          type === 'info' ? 'alert-info' : 'alert-danger';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show attendance-notification position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <div class="d-flex align-items-center">
                    <i class="${icon} fa-lg me-3"></i>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">${title}</h6>
                        <p class="mb-0 small">${message}</p>
                    </div>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(() => {
            notification.alert('close');
        }, duration);
    }
}

// Handle pagination clicks
$(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    const url = $(this).attr('href');
    const page = new URL(url).searchParams.get('page');
    $('input[name="page"]').val(page);
    loadMeetings();
});

// HR Action Functions (keep existing functions)
function sendReminder(type, meetingId) {
    // Your existing sendReminder function
}

function generateMeetingLink(meetingId) {
    // Your existing generateMeetingLink function
}

function generateQRCode(meetingId) {
    // Your existing generateQRCode function
}
</script>
@endpush