@extends('admin.master')
@section('content')

{{-- ============= PAGE STYLE ============= --}}
<style>
body{background:#f8fafc;}

/* HEADER */
.dashboard-title{
    text-align:center;font-size:22px;font-weight:700;color:red;margin-bottom:25px;
}

/* SUMMARY BOX */
.summary-container{
    display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:30px;
}
.summary-card{
    background:#fff;padding:18px;border-radius:10px;display:flex;align-items:center;gap:15px;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.summary-icon{
    font-size:28px;background:#eef6ff;padding:14px;border-radius:50%;color:#0056d6;
}
.summary-info h3{font-size:22px;margin:0;font-weight:700;color:#111;}
.summary-info span{font-size:14px;color:#666;}

/* FILTER BAR */
.filter-row{
    display:grid;grid-template-columns:repeat(6,1fr);gap:10px;background:#fff;padding:15px;
    border-radius:10px;margin-bottom:15px;box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.filter-row select,.filter-row input{
    padding:8px;border-radius:6px;border:1px solid #ccc;
}
.add-btn{
    background:#1c54d1;color:#fff;padding:8px 15px;font-weight:600;border-radius:6px;border:none;
}

/* TABLE */
.table-wrapper{
    background:#fff;border-radius:10px;padding:0;box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
table thead{background:#f1f5f9;}
table th,table td{font-size:14px;padding:9px 10px;border-bottom:1px solid #e8e8e8!important;}
.status-badge{
    padding:5px 10px;border-radius:5px;font-size:12px;font-weight:600;
}
.dept-badge{
    background:#1d4ed8;color:#fff;padding:3px 8px;font-size:11px;border-radius:4px;margin-right:4px;
}
</style>

<div class="container-fluid mt-3">

    <h3 class="dashboard-title">HR ADMIN Dashboard</h3>

    <!-- Summary Section -->
    <div class="summary-container">
        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-people"></i></div>
            <div class="summary-info"><span>Total Movements</span><h3>{{ $totalVisits }}</h3></div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="summary-info"><span>Sales</span><h3>{{ number_format($highestValue,2) }}</h3></div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-building"></i></div>
            <div class="summary-info"><span>Companies</span><h3>{{ $totalCompanies }}</h3></div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-telephone"></i></div>
            <div class="summary-info"><span>Calls</span><h3>{{ $totalDays }}</h3></div>
        </div>
    </div>

  <!-- FILTERS -->
<form method="GET" action="{{ route('admin.movement.index') }}" class="filter-row" id="autoFilterForm">

    <select name="staff" id="staffSelect" onchange="autoSubmit()">
        <option value="">Staff</option>
        @foreach($allStaff as $staff)
            <option value="{{ $staff->id }}" {{ request('staff')==$staff->id?'selected':'' }}>
                {{ $staff->name }}
            </option>
        @endforeach
    </select>

    <select name="department" id="departmentSelect" onchange="autoSubmit()">
        <option value="">Department</option>
        @foreach($departments as $dept)
            <option value="{{ $dept }}" {{ request('department')==$dept?'selected':'' }}>
                {{ ucfirst(str_replace('_',' ',$dept)) }}
            </option>
        @endforeach
    </select>

    <select name="movement_type" onchange="autoSubmit()">
        <option value="">Movement Type</option>
        @foreach($movementTypes as $type)
            <option value="{{ $type }}" {{ request('movement_type')==$type?'selected':'' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>

    <input type="date" name="date" value="{{ request('date') }}" onchange="autoSubmit()">

    <select name="status" onchange="autoSubmit()">
        <option value="">Status</option>
        @foreach($statuses as $status)
            <option value="{{ $status }}" {{ request('status')==$status?'selected':'' }}>
                {{ $status }}
            </option>
        @endforeach


        
    </select>

</form>

<script>
function autoSubmit(){
    document.getElementById("autoFilterForm").submit();
}
</script>

    <div class="text-end mb-2">
        <a href="{{ route('admin.movement.create') }}" class="add-btn">+ Add Movement</a>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>SL</th><th>Date</th><th>Staff</th><th>Department</th><th>Type</th>
                <th>Location</th><th>Time</th><th>Duration</th><th>Status</th>
            </tr>
            </thead>

            <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $record->date?date('d M Y',strtotime($record->date)):'-' }}</td>
                    <td>{{ $record->admin->name ?? '-' }}</td>

                    {{-- Decode JSON Department --}}
                    <td>
                        @php $dept = json_decode($record->admin->department,true) ?? []; @endphp
                        @foreach($dept as $d)
                            <span class="dept-badge">{{ ucfirst(str_replace('_',' ',$d)) }}</span>
                        @endforeach
                    </td>

                    <td>{{ $record->meeting_type??'-' }}</td>
                    <td>{{ $record->area??'-' }}</td>

                 <td>
                            @if($record->start_time && $record->end_time)
                                {{ \Carbon\Carbon::parse($record->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($record->end_time)->format('h:i A') }}
                            @elseif($record->start_time)
                                {{ \Carbon\Carbon::parse($record->start_time)->format('h:i A') }} -
                                {{ $record->duration ? 'N/A' : 'N/A' }}
                            @else
                                -
                            @endif
                        </td>

                    <td>{{ $record->duration? gmdate('H\h i\m',strtotime($record->duration)):'-' }}</td>

                    <td>
                        <span class="status-badge"
                              style="background:{{ $record->status=='Completed'?'#d4f8d4':'#ffe9b3' }};
                                     color:{{ $record->status=='Completed'?'#0d8a25':'#b36b00' }};">
                            {{ $record->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-3">{{ $records->withQueryString()->links() }}</div>
    </div>

</div>

{{-- ========== JS FOR SELECT2 ========= --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('#departmentSelect,#staffSelect').select2({
    placeholder:"Select option",width:"100%"
});
</script>

@endsection




