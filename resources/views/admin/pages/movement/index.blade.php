@extends('admin.master')
@section('content')

<style>
body{background:#f8fafc;}

/* ===== HEADER ===== */
.dashboard-title{
    text-align:center;
    font-size:22px;
    font-weight:700;
    color:red;
    margin-bottom:25px;
}

/* ===== SUMMARY BOXES ===== */
.summary-container{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-bottom:30px;
}
.summary-card{
    background:#fff;
    padding:18px;
    border-radius:10px;
    display:flex;
    align-items:center;
    gap:15px;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.summary-icon{
    font-size:28px;
    background:#eef6ff;
    padding:14px;
    border-radius:50%;
    color:#0056d6;
}
.summary-info h3{font-size:22px;margin:0;font-weight:700;color:#111;}
.summary-info span{font-size:14px;color:#666;}

/* ===== FILTER BAR ===== */
.filter-row{
    display:grid;
    grid-template-columns:repeat(5,1fr) auto;
    gap:10px;
    background:#fff;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.filter-row select,input{
    padding:8px;
    border-radius:6px;
    border:1px solid #ccc;
}
.add-btn{
    background:#1c54d1;
    color:#fff;
    padding:8px 15px;
    font-weight:600;
    border-radius:6px;
    border:none;
}

/* ===== TABLE ===== */
.table-wrapper{
    background:#fff;
    border-radius:10px;
    padding:0;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
table thead{
    background:#f1f5f9;
}
table th,table td{
    font-size:14px;
    padding:9px 10px;
    border-bottom:1px solid #e8e8e8 !important;
}
.status-badge{
    background:#d4f8d4;
    color:#0d8a25;
    padding:5px 10px;
    font-size:12px;
    border-radius:5px;
    font-weight:600;
}
</style>



<div class="container-fluid mt-3">

    <h3 class="dashboard-title">HR ADMIN Dashboard</h3>

    <!-- Summary Boxes -->
    <div class="summary-container">

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-people"></i></div>
            <div class="summary-info">
                <span>Total Movements</span>
                <h3>{{ $totalVisits }}</h3>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="summary-info">
                <span>Sales</span>
                <h3>{{ $highestValue }}</h3>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-building"></i></div>
            <div class="summary-info">
                <span>General</span>
                <h3>{{ $totalCompanies }}</h3>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon"><i class="bi bi-telephone"></i></div>
            <div class="summary-info">
                <span>Calls</span>
                <h3>{{ $totalDays }}</h3>
            </div>
        </div>
    </div>


 <!-- Filters -->
<form method="GET" action="{{ route('admin.movement.index') }}" class="filter-row">
    <select name="staff">
        <option value="">Staff</option>
        @foreach($allStaff as $staff)
            <option value="{{ $staff->id }}" {{ request('staff') == $staff->id ? 'selected' : '' }}>
                {{ $staff->name }}
            </option>
        @endforeach
    </select>

    {{-- <select name="department">
        <option value="">Department</option>
        @foreach($departments as $dept)
            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                {{ $dept }}
            </option>
        @endforeach
    </select> --}}

    <select name="movement_type">
        <option value="">Movement Type</option>
        @foreach($movementTypes as $type)
            <option value="{{ $type }}" {{ request('movement_type') == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>

    <input type="date" name="date" value="{{ request('date') }}">

    <select name="status">
        <option value="">Status</option>
        @foreach($statuses as $status)
            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="add-btn">Filter</button>

    <a href="{{ route('admin.movement.create') }}" class="add-btn">+ Add Movement</a>
</form>


    <!-- Table -->
    <div class="table-wrapper">
        <table class="table">
            <thead>
            <tr>
                <th>SL</th><th>Date</th><th>Staff</th><th>Department</th><th>Movement Type</th>
                <th>Location</th><th>Time</th><th>Duration</th><th>Status</th>
            </tr>
            </thead>
            <tbody>

            @foreach($records as $key=>$record)
                   <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d M Y', strtotime($record->date)) }}</td>
                        <td>{{ $record->admin->name ?? 'N/A' }}</td>
                        <td>{{ $record->department ?? '-' }}</td>
                        <td>{{ $record->meeting_type ?? '-' }}</td>
                        <td>{{ $record->area ?? '-' }}</td>

                       <td>
                                    {{ $record->created_at ? $record->created_at->format('h:i A') : '-' }}
                                    -
                                    {{ $record->updated_at ? $record->updated_at->format('h:i A') : '-' }}
                                </td>


                             <td>
                                @if($record->duration)
                                    @php
                                        $duration = \Carbon\Carbon::parse($record->duration);
                                        $hours = $duration->format('H');
                                        $minutes = $duration->format('i');
                                    @endphp
                                    
                                    {{ $hours }}h {{ $minutes }}m
                                @else
                                    -
                                @endif
                            </td>

                        {{-- Status Badge color dynamic --}}
                        <td>
                            <span class="status-badge"
                                style="background:{{ $record->status=='Completed'?'#d4f8d4':'#ffe9b3' }};
                                        color:{{ $record->status=='Completed'?'#107b22':'#b36b00' }};">
                                {{ $record->status }}
                            </span>
                        </td>
                    </tr>

            @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
